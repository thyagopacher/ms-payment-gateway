<?php

namespace App\Services\Banks\Santander;

use App\Clients\Banks\Santander\SantanderBoletoClient;
use App\Contracts\BankSlipInterface;

class SantanderBoletoService implements BankSlipInterface
{

    protected SantanderBoletoClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new SantanderBoletoClient();
    }

    public function create(array $data): array
    {
        return $this->apiBanco->createBankSlip($data);
    }

    public function cancel(array $data): array
    {
        return $this->apiBanco->cancelBankSlip($data);
    }

    public function getBankSlip(array $filters): array
    {
        return $this->apiBanco->getBankSlip($filters);
    }

    public function print(int $boletoId): string
    {
        $documentData = $this->apiBanco->generateDocument('12345678900', 'billId');
        $pdfContent = file_get_contents($documentData['link']);
        return $pdfContent;
    }
}
