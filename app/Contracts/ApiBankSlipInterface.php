<?php

namespace App\Contracts;

interface ApiBankSlipInterface
{

    public function createBankSlip(array $data): array;

    public function cancelBankSlip (array $data): array;

    public function getBankSlip(array $filters): array;

    public function registerWebhook (array $data): array;
}
