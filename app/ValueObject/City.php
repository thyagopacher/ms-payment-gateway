<?php

namespace App\ValueObject;

use InvalidArgumentException;

class City
{

    public function __construct(
        private string $value
    )
    {
        if (strlen($value) <= 2) {
            throw new InvalidArgumentException(__('validation.person_city'));
        }

        $this->value = htmlspecialchars($value);
        $this->value = strtoupper($this->value);
    }

    public static function from(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

}
