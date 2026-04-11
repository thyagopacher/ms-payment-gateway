<?php

namespace App\Services\Banks\BancoDoBrasil;

use App\Clients\Banks\BancoDoBrasil\BancoDoBrasilBoletoClient;
use App\Contracts\BankSlipServiceInterface;

class BancoDoBrasilBoletoService implements BankSlipServiceInterface
{

    protected BancoDoBrasilBoletoClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new BancoDoBrasilBoletoClient();
    }

    public function create(array $data): array
    {
        return $this->apiBanco->createBoleto($data);
    }

    public function print(int $boletoId): string
    {
        // lógica para imprimir boleto do Banco do Brasil
        return "Boleto do Banco do Brasil impresso com ID: {$boletoId}";
    }
}
