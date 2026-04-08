<?php

namespace App\Clients\Banks\BancoDoBrasil;

use App\Contracts\ApiBancoBoletoInterface;
use GuzzleHttp\Client;

class BancoDoBrasilBoletoClient extends BancoDoBrasilClient implements ApiBancoBoletoInterface
{

    public function __construct()
    {
        parent::__construct();
    }


    public function createBoleto(array $data): array
    {
        $client = new Client();

        $response = $client->post($this->apiUrl . '/boleto-hibrido/cobranca-registro/v1/gerarBoleto', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token,
            ],
            'json' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        return $body;
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
