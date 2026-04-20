<?php

namespace App\Services;

use App\Contracts\PaymentMethodInterface;
use App\Factories\BankFactory;

class PixService implements PaymentMethodInterface
{

    public function create(array $data): array
    {
        return BankFactory::make($data['bank'])->pix()->generateQrCode($data);
    }

    public function getStatus(array $filters): array
    {
        // Implementação da obtenção do status do pagamento com cartão de crédito
        return ['status' => 'pending']; // Retorna um array com o status do pagamento
    }

    public function cancel(array $data): bool
    {
        // Implementação do cancelamento do pagamento com cartão de crédito
        return true; // Retorna true se o cancelamento for bem-sucedido
    }

    public function refund(array $data): bool
    {
        // Implementação do reembolso do pagamento com cartão de crédito
        return true; // Retorna true se o reembolso for bem-sucedido
    }

    public function generateQrCode(array $data): string
    {
        $qrcode = BankFactory::make($data['bank'])->pix()->generateQrCode($data);
        return $qrcode['qrcode'];
    }
}
