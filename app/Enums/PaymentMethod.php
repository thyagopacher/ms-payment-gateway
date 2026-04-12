<?php

namespace App\Enums;

enum PaymentMethod: string
{
    //'pix', 'bank_slip', 'credit_card'
    case PIX = 'pix';
    case BANK_SLIP = 'bank_slip';
    case CREDIT_CARD = 'credit_card';

    // Métodos úteis (opcional, mas muito recomendado)
    public function isFinal(): bool
    {
        return in_array($this, [self::PIX, self::BANK_SLIP, self::CREDIT_CARD]);
    }

    public function isPix(): bool
    {
        return $this === self::PIX;
    }

    public function isBankSlip(): bool
    {
        return $this === self::BANK_SLIP;
    }

    public function isCreditCard(): bool
    {
        return $this === self::CREDIT_CARD;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
