<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoletoRequest;
use App\Services\BoletoService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function processPayment(Request $request)
    {
        // Lógica para processar o pagamento
        return response()->json(['message' => 'Pagamento processado com sucesso']);
    }

    public function getPayments()
    {
        // Lógica para obter os pagamentos
        return response()->json(['payments' => []]);
    }

    public function cancelPayment($id)
    {
        // Lógica para cancelar um pagamento
        return response()->json(['message' => 'Pagamento cancelado com sucesso']);
    }

    public function confirmPayment($id)
    {
        // Lógica para confirmar um pagamento
        return response()->json(['message' => 'Pagamento confirmado com sucesso']);
    }

    public function createBoleto(BoletoRequest $request)
    {
        $params = $request->validated();
        $service = new BoletoService();
        $bank = $service->resolveBank($params['bank']);

        return $bank->create($params);
    }
}
