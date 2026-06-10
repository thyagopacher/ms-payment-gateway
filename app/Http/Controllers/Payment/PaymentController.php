<?php

namespace App\Http\Controllers\Payment;

use App\Dto\PaymentoDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Services\Payment\PaymentService;
use App\Services\Reports\OrderCsvReport;
use App\Services\Reports\OrderPdfReport;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PaymentController extends Controller
{

    public function __construct(private PaymentService $paymentService)
    {

    }

    #[OA\Post(
        path: "/api/payment",
        summary: "Create new payment",
        responses: [
            new OA\Response(
                response: 201,
                description: 'Payment created successfully'
            )
        ]
    )]
    public function store(PaymentRequest $request)
    {
        $data = $request->validated();
        $paymentDto = PaymentoDTO::fromArray($data);
        $payment = $this->paymentService->createPayment($paymentDto);

        return response()->json([
            'success' => true,
            'payment' => $payment
        ], 201);
    }

    #[OA\Put(
        path: "/api/payment/{id}",
        summary: "Update payment",
        responses: [
            new OA\Response(
                response: 200,
                description: 'Payment updated successfully'
            )
        ]
    )]
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

    #[OA\Delete(
        path: "/api/payment/{id}",
        summary: "Delete payment",
        responses: [
            new OA\Response(
                response: 200,
                description: 'Payment deleted successfully'
            )
        ]
    )]
    public function destroy(int $id)
    {
        $res = $this->paymentService->delete($id);

        return response()->json([
            'success' => $res,
            'msg' => $res ? __('api.deleted_success') : __('api.deleted_error')
        ]);
    }

    #[OA\Get(
        path: "/api/payment/{id}",
        summary: "Get payment by ID",
        responses: [
            new OA\Response(
                response: 200,
                description: 'Payment found successfully'
            )
        ]
    )]
    public function show(int $id): PaymentResource
    {
        $res = $this->paymentService->getPayment($id);
        return new PaymentResource($res);
    }

    #[OA\Get(
        path: "/api/payment",
        summary: "Get all payments with filters",
        responses: [
            new OA\Response(
                response: 200,
                description: 'Payment found successfully'
            )
        ]
    )]
    public function index(Request $request)
    {
        $filters = $request->all();

        $payments = $this->paymentService->getPayments($filters);
        return PaymentResource::collection($payments);
    }

    #[OA\Get(
        path: "/api/payments/report/csv",
        summary: "Generate CSV report for payments with filters",
        responses: [
            new OA\Response(
                response: 200,
                description: 'Payment found successfully'
            )
        ]
    )]
    public function csvReport(
        Request $request,
        OrderCsvReport $report
    ) {
        $filters = $request->all();
        $csvContent = $report->generate($filters);

        return response(
            $csvContent
        )
        ->header('Content-Type', 'text/csv')
        ->header(
            'Content-Disposition',
            'attachment; filename="' . $report->filename() . '"'
        );
    }

    #[OA\Get(
        path: "/api/payments/report/pdf",
        summary: "Generate PDF report for payments with filters",
        responses: [
            new OA\Response(
                response: 200,
                description: 'Payment found successfully'
            )
        ]
    )]
    public function pdfReport(
        Request $request,
        OrderPdfReport $report
    ) {
        $filters = $request->all();
        $pdfContent = $report->generate($filters);

        return response(
            $pdfContent
        )
        ->header('Content-Type', 'application/pdf')
        ->header(
            'Content-Disposition',
            'attachment; filename="' . $report->filename() . '"'
        );
    }


}
