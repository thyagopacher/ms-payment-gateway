<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankSlipRequest;
use App\Services\Bank\Boleto\BankSlipService;

class BankSlipController extends Controller
{

    public function __construct(
        private BankSlipService $bankSlipService
    ) {

    }

    public function generateBillingDocument(BankSlipRequest $request)
    {
        $data = $request->validated();
        $res = $this->bankSlipService->create($data);
        return response()->json($res);
    }

    public function printBillingDocument(int $boletoId)
    {
        $pdfContent = $this->bankSlipService->print($boletoId);
        return response($pdfContent, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="boleto.pdf"');
    }
}
