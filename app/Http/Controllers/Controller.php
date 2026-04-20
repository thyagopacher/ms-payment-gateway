<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function success(string $message, array $data = [], int $httpCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $httpCode);
    }
}
