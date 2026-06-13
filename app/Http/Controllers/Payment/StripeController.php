<?php

namespace App\Http\Controllers\Payment;

use App\DTO\CreateChargeDTO;
use App\Services\Payment\StripeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class StripeController
{
    public function __construct(
        private StripeService $stripeService
    ) {

    }

    #[OA\Post(
        path: '/api/stripe/charges/create',
        operationId: 'createCharge',
        summary: 'Create a new charge',
        description: 'Creates a new charge in Stripe.',
        tags: ['Stripe'],
        requestBody: new OA\RequestBody(
            required: true,
            description: 'Charge data',
            content: new OA\JsonContent(
                required: ['amount', 'currency', 'source'],
                properties: [
                    new OA\Property(
                        property: 'amount',
                        type: 'integer',
                        example: 1000,
                        description: 'Amount in cents'
                    ),
                    new OA\Property(
                        property: 'currency',
                        type: 'string',
                        example: 'brl',
                        description: 'ISO 4217 currency code'
                    ),
                    new OA\Property(
                        property: 'source',
                        type: 'string',
                        example: 'tok_visa',
                        description: 'Stripe payment source token'
                    ),
                    new OA\Property(
                        property: 'metadata',
                        type: 'object',
                        example: [
                            'order_id' => '123',
                            'customer_id' => '456'
                        ],
                        description: 'Additional metadata'
                    )
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Charge created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: 'id',
                            type: 'string',
                            example: 'ch_3MtwBwLkdIwHu7ix0snN0B15'
                        ),
                        new OA\Property(
                            property: 'amount',
                            type: 'integer',
                            example: 1000
                        ),
                        new OA\Property(
                            property: 'currency',
                            type: 'string',
                            example: 'brl'
                        ),
                        new OA\Property(
                            property: 'status',
                            type: 'string',
                            example: 'succeeded'
                        )
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: 'Invalid request'
            ),
            new OA\Response(
                response: 500,
                description: 'Internal server error'
            )
        ]
    )]
    public function createCharge(Request $request): object {
        $params = $request->all();
        $charge = $this->stripeService->createCharge(
            CreateChargeDTO::fromArray($params)
        );

        return response()->json($charge);
    }

    #[OA\Get(
        path: "/api/stripe/charges/{chargeId}/get",
        summary: "Return details of a specific charge",
        parameters: [
            new OA\Parameter(
                name: "chargeId",
                in: "path",
                required: true,
                description: "ID of the charge to retrieve",
                schema: new OA\Schema(
                    type: "string"
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Details of the charge"
            )
        ]
    )]
    public function getCharge(string $chargeId): object
    {
        return $this->stripeService->getCharge($chargeId);
    }

    #[OA\Get(
        path: "/api/stripe/charges/{limit}/list",
        summary: "List charges",
        parameters: [
            new OA\Parameter(
                name: "limit",
                in: "query",
                required: false,
                description: "Maximum number of charges",
                schema: new OA\Schema(
                    type: "integer",
                    default: 10
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of charges"
            )
        ]
    )]
    public function listCharges(int $limit = 10): object
    {
        return $this->stripeService->listCharges($limit);
    }

    #[OA\Post(
        path: "/api/stripe/charges/{chargeId}/capture",
        summary: "Capture a charge",
        parameters: [
            new OA\Parameter(
                name: "chargeId",
                in: "path",
                required: true,
                description: "ID of the charge to capture",
                schema: new OA\Schema(
                    type: "string"
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Details of the captured charge"
            )
        ]
    )]
    public function captureCharge(string $chargeId): object
    {
        return $this->stripeService->captureCharge($chargeId);
    }

    #[OA\Put(
        path: "/api/stripe/charges/{chargeId}",
        summary: "Update charge details",
        parameters: [
            new OA\Parameter(
                name: "chargeId",
                in: "path",
                required: true,
                description: "ID of the charge to retrieve",
                schema: new OA\Schema(
                    type: "string"
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Details of the charge"
            )
        ]
    )]
    public function updateCharge(
        string $chargeId,
        Request $request
    ): object {
        $params = $request->all();
        return $this->stripeService->updateCharge(
            $chargeId,
            $params['metadata']
        );
    }

    #[OA\Post(
        path: "/api/stripe/refund/{chargeId}",
        summary: "Refund charge with total amount",
        parameters: [
            new OA\Parameter(
                name: "chargeId",
                in: "path",
                required: true,
                description: "ID of the charge to retrieve",
                schema: new OA\Schema(
                    type: "string"
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Details of the charge"
            )
        ]
    )]
    public function refundCharge(string $chargeId): JsonResponse
    {
        return $this->stripeService->refundCharge($chargeId);
    }

    #[OA\Post(
        path: "/api/stripe/refund/{chargeId}/{amount}",
        summary: "Refund charge with specific amount",
        parameters: [
            new OA\Parameter(
                name: "chargeId",
                in: "path",
                required: true,
                description: "ID of the charge to retrieve",
                schema: new OA\Schema(
                    type: "string"
                )
            ),
            new OA\Parameter(
                name: "amount",
                in: "path",
                required: true,
                description: "Amount to refund",
                schema: new OA\Schema(
                    type: "integer"
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Details of the charge"
            )
        ]
    )]
    public function partialRefundCharge(
        string $chargeId,
        int $amount
    ): object {
        return $this->stripeService->partialRefundCharge($chargeId, $amount);
    }

    #[OA\Get(
        path: "/api/stripe/refunds/{refundId}",
        summary: "Get refund details",
        parameters: [
            new OA\Parameter(
                name: "refundId",
                in: "path",
                required: true,
                description: "ID of the refund to retrieve",
                schema: new OA\Schema(
                    type: "string"
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Details of the refund"
            )
        ]
    )]
    public function getRefund(string $refundId): object
    {
        return $this->stripeService->getRefund($refundId);
    }
}
