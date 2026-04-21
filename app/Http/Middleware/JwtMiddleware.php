<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Middleware JWTMiddleware:', [
            'uri' => $request->getRequestUri(),
            'method' => $request->getMethod(),
            'route' => $request->route()->getName() ?? 'N/A'
        ]);
        $key = config('jwt.secret');

        $authHeader = $request->header('Authorization');
        if (empty($authHeader)) {
            return response()->json(['error' => 'Token não fornecido', 'success' => false], 401);
        }

        $jwt = $authHeader;
        $jwt = str_replace("Bearer ", "", $jwt);

        try {
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        } catch (Throwable $e) {
            Log::error('Erro ao decodificar JWT: ' . $e->getMessage());
            return response()->json(['error' => 'Token inválido', 'success' => false], 401);
        }

        $resNext = $next($request);
        return $resNext;
    }
}
