<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundException extends NotFoundHttpException
{
    public function __construct(
        string $message = 'Recurso não encontrado.',
        ?\Throwable $previous = null,
        int $code = 0,
        array $headers = []
    ) {
        parent::__construct($message, $previous, $code, $headers);
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'error' => 'not_found',
            'message' => $this->getMessage(),
            'status' => 404,
        ], 404);
    }
}
