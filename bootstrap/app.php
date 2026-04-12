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
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->dontReport([
            \Illuminate\Validation\ValidationException::class,
            \Illuminate\Auth\AuthenticationException::class,
        ]);

        $exceptions->report(function (Throwable $e) {
            if ($e instanceof NotFoundHttpException ||
                $e instanceof NotFoundException) {
                return false; // não envia para o Sentry
            }

            Log::error($e->getMessage());
        });

        $exceptions->render(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
                $status = $e->getCode();

                if ($status < 400 || $status >= 600) {
                    $status = 500;
                }

                return response()->json([
                    'message' => $e->getMessage(),
                    'status' => $status,
                ], $status);
            }
        });
        Integration::handles($exceptions);
    })->create();
