<?php

namespace App\Http\Controllers;

/**
 * Controller class
 *
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Gateway de Pagamentos API",
 *         version="1.0.0",
 *         description="Documentação da API"
 *     )
 * )
 *
 * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
 */
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
