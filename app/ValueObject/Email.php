<?php

namespace App\ValueObject;

use InvalidArgumentException;

class Email
{

    public function __construct(
        private string $value
    )
    {
        if (!$this->isValid($value)) {
            throw new InvalidArgumentException(__('validation.person_mail'). ' - '. $value, 422);
        }
    }

    public static function from(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function isValid(string $value): bool
    {
        return FILTER_VAR($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
