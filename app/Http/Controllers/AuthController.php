<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{

    public function __construct(

    ) {

    }

    #[OA\Post(
        path: "/api/auth",
        summary: "Auth API",
        responses: [
            new OA\Response(
                response: 200,
                description: 'Auth API'
            ),
            new OA\Response(
                response: 422,
                description: 'Error in auth API'
            )
        ]
    )]
    public function auth()
    {
        $key = config('jwt.secret');
        $expiresIn = config('jwt.ttl');
        $expiresInTimestamp = time() + $expiresIn;
        $timeStampCreated = time();

        $payload = [
            "iss" => config('app.name'),
            "iat" => $timeStampCreated,
            "exp" => $expiresInTimestamp
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');

        return response()->json([
            'token' => $jwt,
            'expires_in' => $expiresIn,
            'expires_at' => date('Y-m-d H:i:s', $expiresInTimestamp)
        ]);
    }

}
