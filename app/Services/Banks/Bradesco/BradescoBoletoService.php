<?php

namespace App\Services\Banks\Bradesco;

use App\Clients\Banks\Bradesco\BradescoBoletoClient;
use App\Contracts\BoletoServiceInterface;

class BradescoBoletoService implements BoletoServiceInterface
{

    protected BradescoBoletoClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new BradescoBoletoClient();
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
