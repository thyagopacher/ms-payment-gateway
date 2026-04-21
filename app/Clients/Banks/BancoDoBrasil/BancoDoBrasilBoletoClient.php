<?php

namespace App\Clients\Banks\BancoDoBrasil;

use App\Contracts\ApiBankSlipInterface;
use GuzzleHttp\Client;

class BancoDoBrasilBoletoClient extends BancoDoBrasilClient implements ApiBankSlipInterface
{

    public function __construct()
    {
        parent::__construct();

        $this->headersAuth['Authorization'] = 'Bearer ' . $this->getToken();
    }


    public function createBankSlip(array $data): array
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

    public function cancelBankSlip(array $data): array
    {
        // implementação de cancelamento de boleto para Banco do Brasil
        return [];
    }

    public function getBankSlip(array $filters): array
    {
        $dadosBoleto = [];
        return $dadosBoleto;
    }

    public function registerWebhook (array $data): array
    {
        // implementação de registro de webhook para Banco do Brasil
        return [];
    }
}
