<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InvalidBankException extends NotFoundHttpException
{
    public function __construct(
        string $message = 'Banco inválido.',
        ?\Throwable $previous = null,
        int $code = 0,
        array $headers = []
    ) {
        parent::__construct($message, $previous, $code, $headers);
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'error' => 'invalid_bank',
            'message' => $this->getMessage(),
            'status' => 500,
        ], 500);
    }
}
