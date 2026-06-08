<?php

namespace App\Dto;

use App\ValueObject\City;
use App\ValueObject\State;

class CityDTO
{
    public function __construct(
        public City $city,
        public State $state
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            city: City::from($data['name']),
            state: State::from(strtoupper($data['state'])),
        );
    }

    public function toArray(): array
    {
        return [
            'city' => $this->city->getValue(),
            'state' => $this->state->getValue()
        ];
    }
}
