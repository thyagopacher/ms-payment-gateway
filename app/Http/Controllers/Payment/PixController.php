<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\PixRequest;
use App\Services\Payment\PixService;
use OpenApi\Attributes as OA;

class PixController extends Controller
{

    public function __construct(
        private PixService $pixService
    ) {

    }

    #[OA\Post(
        path: "/api/pix",
        summary: "Create new payment pix",
        tags: ['Pix'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Pix Payment created successfully'
            )
        ]
    )]
    public function create(PixRequest $request)
    {
        $data = $request->validated();
        $res = $this->pixService->create($data);
        return response()->json($res, 201);
    }

}
