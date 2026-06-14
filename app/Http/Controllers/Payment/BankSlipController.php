<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankSlipRequest;
use App\Services\Payment\BankSlipService;
use OpenApi\Attributes as OA;

class BankSlipController extends Controller
{

    public function __construct(
        private BankSlipService $bankSlipService
    ) {

    }

    #[OA\Post(
        path: "/api/bank-slip/create",
        summary: "Generate bank slip for a given payment",
        tags: ['BankSlip'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Bank slip created successfully'
            )
        ]
    )]
    public function generateBillingDocument(BankSlipRequest $request)
    {
        try {
            $data = $request->validated();
            $res = $this->bankSlipService->create($data);

            return $this->success(__('created_success'), $res);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 500);
        }
    }

    #[OA\Get(
        path: "/api/bank-slip/print/{boletoId}",
        summary: "Generate PDF for a given boleto ID",
        tags: ['BankSlip'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Bank slip found successfully'
            )
        ]
    )]
    public function printBillingDocument(int $boletoId)
    {
        try {
            $pdfContent = $this->bankSlipService->print($boletoId);
            return response($pdfContent, 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="boleto.pdf"');
        } catch (\Exception $e) {
            $code = $e->getCode() ?: 500;
            $code = ($code < 400 || $code >= 600) ? 500 : $code; // Garantir que o código seja um status HTTP válido
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], $code);
        }
    }
}
