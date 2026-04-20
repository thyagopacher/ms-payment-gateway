<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankSlipRequest;
use App\Services\BankSlipService;

class BankSlipController extends Controller
{

    public function __construct(
        private BankSlipService $bankSlipService
    ) {

    }

    public function generateBillingDocument(BankSlipRequest $request)
    {
        try {
            $data = $request->validated();
            $res = $this->bankSlipService->create($data);

            return $this->success(__('created_success'), $res);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 500);
        }
    }

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
