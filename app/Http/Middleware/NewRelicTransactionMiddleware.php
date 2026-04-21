<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NewRelicTransactionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route();
        $endpointTransaction = $route->uri();
        $nameTransaction = $request->method() . $endpointTransaction;

        newrelic_name_transaction($nameTransaction);
        newrelic_add_custom_parameter('route', $request->path());
        newrelic_add_custom_parameter('method', $request->method());

        return $next($request);
    }
}
