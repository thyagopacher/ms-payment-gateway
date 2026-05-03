<?php

namespace App\Dto;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\ValueObject\Document;
use App\ValueObject\Money;

class PaymentoDTO
{
    public function __construct(
        public string $id,
        public PaymentStatus $status,
        public Money $amount,
        public PaymentMethod $payment_method,
        public Document $document,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            status: PaymentStatus::from($data['status']),
            amount: new Money($data['amount'] ?? 0),
            payment_method: PaymentMethod::from($data['payment_method']),
            document: new Document($data['document'] ?? ''),
        );
    }
}
