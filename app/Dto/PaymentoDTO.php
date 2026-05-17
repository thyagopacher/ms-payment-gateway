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
        public string $dueDate,
        public string $paidAt
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? '',
            status: PaymentStatus::from($data['status']),
            amount: new Money($data['amount'] ?? 0),
            payment_method: PaymentMethod::from($data['payment_method']),
            document: new Document($data['person_document']),
            dueDate: $data['bill_due_date'],
            paidAt: $data['bill_paid_at']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status->value,
            'amount' => $this->amount->getValue(),
            'payment_method' => $this->payment_method->value,
            'document' => $this->document->getValue(),
            'due_date' => $this->dueDate,
            'paid_at' => $this->paidAt
        ];
    }
}
