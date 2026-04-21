<?php

namespace App\DTO;

use App\ValueObject\Money;

class PaymentoDTO
{
    public function __construct(
        public string $id,
        public string $status,
        public Money $amount,
        public string $payment_method,
        public string $document,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            status: $data['status'] ?? '',
            amount: new Money($data['amount'] ?? 0),
            payment_method: $data['payment_method'] ?? '',
            document: $data['document'] ?? '',
        );
    }
}
