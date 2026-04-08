<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoletoRequest;
use App\Services\BoletoService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function getPayments()
    {
        // Lógica para obter os pagamentos
        return response()->json(['payments' => []]);
    }

}
