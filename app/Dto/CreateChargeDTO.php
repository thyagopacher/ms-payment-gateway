<?php

namespace App\Dto;

class CreateChargeDTO
{
    public function __construct(
        public readonly int $amount,
        public readonly string $currency,
        public readonly string $source,
        public readonly array $metadata = []
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            amount: $data['amount'],
            currency: $data['currency'],
            source: $data['source'],
            metadata: $data['metadata'] ?? []
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'source' => $this->source,
            'metadata' => $this->metadata,
        ];
    }
}
