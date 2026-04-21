<?php

namespace App\Services;

use App\Contracts\PaymentMethodInterface;
use App\Factories\BankFactory;

class PixService implements PaymentMethodInterface
{

    public function __construct()
    {
        //
    }

    public function create(array $data): array
    {
        $pixMethod = BankFactory::make($data['bank'])->pix();
        return $pixMethod->generateBilling($data);
    }

    public function getStatus(array $filters): array
    {
        // Implementação da obtenção do status do pagamento com cartão de crédito
        return ['status' => 'pending']; // Retorna um array com o status do pagamento
    }

    public function cancel(array $data): array
    {
        $pixMethod = BankFactory::make($data['bank'])->pix();
        $data = $pixMethod->cancelRecurrenceBilling($data);

        return $data;
    }
}
