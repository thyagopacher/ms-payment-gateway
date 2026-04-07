<?php

namespace App\Clients\Banks\Itau;

use App\Contracts\ApiBancoBoletoInterface;

class ItauBoletoClient extends ItauClient implements ApiBancoBoletoInterface
{

    public function __construct()
    {
        parent::__construct();
    }


    public function createBoleto(array $data): array
    {
        // implementação de criação de boleto para Banco do Brasil
        $dadosRetornoBanco = [];
        return $dadosRetornoBanco;
    }

    public function cancelBoleto(string $boletoId): bool
    {
        // implementação de cancelamento de boleto para Banco do Brasil
        return true;
    }

    public function getBoleto(string $boletoId): array
    {
        // implementação de consulta de boleto para Banco do Brasil
        $dadosBoleto = [];
        return $dadosBoleto;
    }

    public function registerWebhook(string $url): bool
    {
        // implementação de registro de webhook para Banco do Brasil
        return true;
    }
}
