<?php

namespace App\Services\Banks\BancoDoBrasil;

use App\Clients\Banks\BancoDoBrasil\BancoDoBrasilBoletoClient;
use App\Contracts\BankSlipInterface;

class BancoDoBrasilBoletoService implements BankSlipInterface
{

    protected BancoDoBrasilBoletoClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new BancoDoBrasilBoletoClient();
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
