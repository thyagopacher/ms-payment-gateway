<?php

namespace App\ValueObject;

class Money
{

    private const ALLOWED_CURRENCIES = ['BRL', 'USD', 'EUR'];

    public function __construct(
        private float $value,
        private string $currency = 'BRL'
    )
    {
        if ($value < 0) {
            throw new \InvalidArgumentException('Money value cannot be negative.');
        }

        if (!is_finite($value)) {
            throw new \InvalidArgumentException('Amount must be a finite number.');
        }

        if (!in_array($currency, self::ALLOWED_CURRENCIES)) {
            throw new \InvalidArgumentException('Invalid currency.');
        }
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
