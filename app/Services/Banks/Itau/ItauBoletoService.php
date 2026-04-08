<?php

namespace App\Services\Banks\Itau;

use App\Clients\Banks\Itau\ItauBoletoClient;
use App\Contracts\BoletoServiceInterface;

class ItauBoletoService implements BoletoServiceInterface
{

    protected ItauBoletoClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new ItauBoletoClient();
    }

    public function create(array $data): array
    {
        $dadosRetornoBanco = [];
        return $dadosRetornoBanco;
    }

    public function print(int $boletoId): string
    {
        // lógica para imprimir boleto do Banco do Brasil
        return "Boleto do Banco do Brasil impresso com ID: {$boletoId}";
    }
}
