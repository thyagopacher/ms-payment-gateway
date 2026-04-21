<?php

namespace App\Services\Banks\Itau;

use App\Clients\Banks\Itau\ItauBoletoClient;
use App\Contracts\BankSlipInterface;

class ItauBoletoService implements BankSlipInterface
{

    protected ItauBoletoClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new ItauBoletoClient();
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
        // lógica para imprimir boleto do Banco do Brasil
        return "Boleto do Banco do Brasil impresso com ID: {$boletoId}";
    }
}
