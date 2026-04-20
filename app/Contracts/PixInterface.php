<?php

namespace App\Contracts;

interface PixInterface
{
    public function generateBilling(array $data): array;
    public function recurrenceBilling(array $data): array;
    public function cancelRecurrenceBilling(array $data): array;
}
