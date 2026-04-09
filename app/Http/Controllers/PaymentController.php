<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function __construct(private PaymentService $paymentService)
    {

    }

    public function getPayments(Request $request)
    {
        $filters = $request->all();

        $payments = $this->paymentService->getPayments($filters);
        return response()->json([
            'success' => true,
            'count' => count($payments),
            'payments' => $payments
        ]);
    }

}
