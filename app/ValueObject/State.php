<?php

namespace App\ValueObject;

use InvalidArgumentException;

class State
{

    public function __construct(
        private string $value
    )
    {
        if (strlen($value) !== 2) {
            throw new InvalidArgumentException(__('validation.person_state'));
        }

        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function getValue(): float
    {
        return $this->value;
    }

}
