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
        // lógica para imprimir boleto do Banco do Brasil
        return "Boleto do Banco do Brasil impresso com ID: {$boletoId}";
    }
}
