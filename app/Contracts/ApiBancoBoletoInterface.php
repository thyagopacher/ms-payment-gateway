<?php

namespace App\Contracts;

interface ApiBancoBoletoInterface
{
    public function authenticate(): array;

    public function createBoleto(array $data): array;

    public function cancelBoleto(string $boletoId): bool;

    public function getBoleto(string $boletoId): array;

    public function registerWebhook(string $url): bool;
}
