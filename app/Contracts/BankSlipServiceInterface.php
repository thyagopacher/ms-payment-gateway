<?php

namespace App\Contracts;

interface BankSlipServiceInterface
{
    public function create(array $data): array;

    public function print(int $boletoId): string;
}
