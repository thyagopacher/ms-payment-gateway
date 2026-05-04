<?php

namespace App\Dto;

use App\ValueObject\State;

class CityDTO
{
    public function __construct(
        public string $name,
        public State $state
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            state: State::fromString(strtoupper($data['state'])),
        );
    }
}
