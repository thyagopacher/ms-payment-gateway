<?php

namespace App\Services;

use App\Contracts\PaymentMethodInterface;
use App\Contracts\QrCodeGenerableInterface;

class PixService implements PaymentMethodInterface, QrCodeGenerableInterface
{
    public function pay(): bool
    {
        // Implementação do pagamento com cartão de crédito
        return true; // Retorna true se o pagamento for bem-sucedido
    }

    public function generateQrCode(): string
    {
        // Implementação da geração do QR Code para o Pix
        return 'QRCodeString'; // Retorna a string do QR Code gerado
    }
}
