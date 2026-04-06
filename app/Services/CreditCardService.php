<?php

namespace App\Services;

use App\PaymentMethodInterface;

class CreditCardService implements PaymentMethodInterface
{
    public function pay(): bool
    {
        // Implementação do pagamento com cartão de crédito
        return true; // Retorna true se o pagamento for bem-sucedido
    }
}
