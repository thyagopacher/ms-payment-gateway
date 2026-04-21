<?php

namespace App\Contracts;

interface BankSlipInterface
{
    public function create(array $data): array;

    public function print(int $boletoId): string;

    public function cancel(array $data): array;

    public function getBankSlip(array $filters): array;
}
