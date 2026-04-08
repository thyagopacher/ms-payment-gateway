<?php

namespace App\Contracts;

interface ApiBankSlipInterface
{

    public function createBoleto(array $data): array;

    public function cancelBoleto(string $boletoId): bool;

    public function getBoleto(string $boletoId): array;

    public function registerWebhook(string $url): bool;
}
