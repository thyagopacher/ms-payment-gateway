<?php

use App\Exceptions\NotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Sentry\Laravel\Integration;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\NewRelicTransactionMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $dontReportExceptions = [
            \Illuminate\Validation\ValidationException::class,
            \Illuminate\Auth\AuthenticationException::class,
        ];
        $exceptions->dontReport($dontReportExceptions);

        $exceptions->report(function (Throwable $e) {
            if (extension_loaded('newrelic')) {
                newrelic_notice_error($e);
            }

            if ($e instanceof NotFoundHttpException ||
                $e instanceof NotFoundException) {
                return false; // não envia para o Sentry
            }

            Log::error($e->getMessage());
        });

        $exceptions->render(function (Throwable $e, $request) {

            if ($request->expectsJson() || str_starts_with($request->path(), 'api/')) {

                $code = $e->getCode();

                if ($code < 400 || $code >= 600) {
                    $code = 500;
                }

                $res = [
                    'message' => $e->getMessage(),
                    'code' => $code,
                    'success' => false
                ];

                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    $res['code'] = 422;
                    $res['message'] = 'Invalid fields';
                }

                if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                    $res['code'] =$e->getStatusCode();
                }

                if (config('app.debug')) {
                    $res['line'] = $e->getLine();
                    $res['file'] = $e->getFile();
                }
                return response()->json($res, $code);
            }
        });
        Integration::handles($exceptions);
    })->create();
