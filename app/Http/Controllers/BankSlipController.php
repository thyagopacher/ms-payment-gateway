<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankSlipRequest;
use App\Services\BankSlipService;
use Illuminate\Support\Facades\Log;

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
            return response()->json($res);
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

            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ], 500);
        }
    }
}
