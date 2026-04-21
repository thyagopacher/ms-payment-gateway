<?php

namespace App\Http\Controllers;

use App\DTO\PaymentoDTO;
use App\Http\Requests\PaymentRequest;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function __construct(private PaymentService $paymentService)
    {

    }

    public function createPayment(PaymentRequest $request)
    {
        $paymentDto = PaymentoDTO::fromArray($request->validated());
        $payment = $this->paymentService->createPayment($paymentDto);
        return response()->json([
            'success' => true,
            'payment' => $payment
        ]);
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
