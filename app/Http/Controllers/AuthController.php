<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{

    public function __construct(
        private UserService $userService
    ) {

    }

    #[OA\Post(
        path: "/api/user/create",
        summary: "Create a new user",
        responses: [
            new OA\Response(
                response: 200,
                description: 'Create user'
            ),
            new OA\Response(
                response: 422,
                description: 'Error in create user API'
            )
        ]
    )]
    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = $this->userService->create(
            $request->validated()
        );

        return response()->json($user, 201);
    }

    #[OA\Post(
        path: "/api/user/auth",
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
