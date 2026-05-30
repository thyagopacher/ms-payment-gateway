<?php

namespace App\ValueObject;

use InvalidArgumentException;

class Document
{

    public function __construct(
        private string $value
    )
    {
        $document = $this->sanitize($value);

        if (!$this->isValid($document)) {
            throw new InvalidArgumentException(__('validation.person_document'). ' - '. $document, 422);
        }

        $this->value = $document;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isCpf(): bool
    {
        return strlen($this->value) === 11;
    }

    public function isCnpj(): bool
    {
        return strlen($this->value) === 14;
    }

    private function validateCpf(string $cpf): bool
    {
        if (strlen($cpf) !== 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $sum = 0;

            for ($i = 0; $i < $t; $i++) {
                $sum += ((int) $cpf[$i]) * (($t + 1) - $i);
            }

            $digit = ((10 * $sum) % 11) % 10;

            if ((int) $cpf[$t] !== $digit) {
                return false;
            }
        }

        return true;
    }

    private function validateCnpj(string $cnpj): bool
    {
        if (strlen($cnpj) !== 14) {
            return false;
        }

        return true;
    }

    private function sanitize(string $document): string
    {
        return preg_replace('/\D/', '', $document);
    }

    private function isValid(string $document): bool
    {
        return $this->validateCpf($document)
            || $this->validateCnpj($document);
    }
}
