<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\PixRequest;
use App\Services\Payment\PixService;

class PixController extends Controller
{

    public function __construct(
        private PixService $pixService
    ) {

    }

    public function create(PixRequest $request)
    {
        $data = $request->validated();
        $res = $this->pixService->create($data);
        return response()->json($res);
    }

}
