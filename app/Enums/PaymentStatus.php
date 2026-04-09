<?php

namespace App\Enums;

enum PaymentStatus: string
{
case PENDING   = 'pending';
    case PAID      = 'paid';
    case FAILED    = 'failed';
    case EXPIRED   = 'expired';
    case CANCELLED = 'cancelled';

    // Métodos úteis (opcional, mas muito recomendado)
    public function isFinal(): bool
    {
        return in_array($this, [self::PAID, self::FAILED, self::CANCELLED, self::EXPIRED]);
    }

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
