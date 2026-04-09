<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;

class AuthController extends Controller
{

    public function __construct(

    ) {

    }

    public function auth()
    {
        $key = config('jwt.secret');
        $expiresIn = config('jwt.ttl');
        $expiresInTimestamp = time() + $expiresIn;

        $payload = [
            "iss" => config('app.name'),     // quem emitiu
            "iat" => time(),            // criado em
            "exp" => $expiresInTimestamp   // expira em 1 hora
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        return response()->json([
            'token' => $jwt,
            'expires_in' => $expiresIn,
            'expires_at' => date('Y-m-d H:i:s', $expiresInTimestamp)
        ]);
    }

}
