<?php

namespace App\Contracts;

interface BoletoServiceInterface
{
    public function create(array $data): array;

    public function print(int $boletoId): string;
}
