<?php

namespace App\Http\Controllers\Payment;

use App\Dto\PaymentoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function __construct(private PaymentService $paymentService)
    {

    }

    public function store(PaymentRequest $request)
    {
        $data = $request->validated();
        $paymentDto = PaymentoDTO::fromArray($data);
        $payment = $this->paymentService->createPayment($paymentDto);

        return response()->json([
            'success' => true,
            'payment' => $payment
        ]);
    }

    public function update(PaymentRequest $request, int $id)
    {
        $data = $request->validated();
        $res = $this->paymentService->update($data, $id);
        $success = !empty($res->id);

        return response()->json([
            'success' => $success,
            'msg' => $success ? __('api.updated_success') : __('api.updated_error')
        ]);
    }

    public function destroy(int $id)
    {
        $res = $this->paymentService->delete($id);

        return response()->json([
            'success' => $res,
            'msg' => $res ? __('api.deleted_success') : __('api.deleted_error')
        ]);
    }

    public function show(int $id): PaymentResource
    {
        $res = $this->paymentService->getPayment($id);
        return new PaymentResource($res);
    }

    public function index(Request $request)
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
