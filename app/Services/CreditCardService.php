<?php

namespace App\Services;

use App\Contracts\PaymentMethodInterface;

class CreditCardService implements PaymentMethodInterface
{
    public function create(array $data): array
    {
        // Implementação da criação do pagamento com cartão de crédito
        return ['status' => 'created']; // Retorna um array com o status da criação
    }

    public function getStatus(array $filters): array
    {
        // Implementação da obtenção do status do pagamento com cartão de crédito
        return ['status' => 'pending']; // Retorna um array com o status do pagamento
    }

    public function cancel(array $data): array
    {
        // Implementação do cancelamento do pagamento com cartão de crédito
        return ['status' => 'cancelled']; // Retorna um array com o status do cancelamento
    }

}
