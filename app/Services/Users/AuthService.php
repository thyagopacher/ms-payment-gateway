<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function __construct() {
    }

    public function login(string $email, string $password): array
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (!$token = Auth::attempt($credentials)) {
            throw new \Exception('Credenciais inválidas.');
        }

        return [
            'token' => $token,
            'type' => 'Bearer',
        ];
    }
}
