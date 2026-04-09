<?php

namespace App\Services\Banks\Santander;

use App\Clients\Banks\Santander\SantanderBoletoClient;
use App\Contracts\BoletoServiceInterface;

class SantanderBoletoService implements BoletoServiceInterface
{

    protected SantanderBoletoClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new SantanderBoletoClient();
    }

    public function create(array $data): array
    {
        return $this->apiBanco->createBoleto($data);
    }

    public function print(int $boletoId): string
    {
        $documentData = $this->apiBanco->generateDocument('12345678900', 'billId');
        $pdfContent = file_get_contents($documentData['link']);
        return $pdfContent;
    }
}
