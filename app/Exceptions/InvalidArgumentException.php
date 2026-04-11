<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InvalidArgumentException extends NotFoundHttpException
{
    public function __construct(
        string $message = 'Argumento inválido.',
        ?\Throwable $previous = null,
        int $code = 400,
        array $headers = []
    ) {
        parent::__construct($message, $previous, $code, $headers);
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'error' => 'invalid_argument',
            'message' => $this->getMessage(),
            'status' => 500,
        ], 500);
    }
}
