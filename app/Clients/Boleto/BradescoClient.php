<?php

namespace App\Clients\Boleto;

use App\Contracts\ApiBancoBoletoInterface;
use GuzzleHttp\Client;

class BradescoClient implements ApiBancoBoletoInterface
{

    private string $apiUrl = '';
    private string $clientId = '';
    private string $clientSecret = '';


    public function __construct()
    {
        // configuração do cliente para Banco do Brasil
        $this->apiUrl = config('services.boleto.bradesco.endpoint');
        $this->clientId = config('services.boleto.bradesco.api_key');
        $this->clientSecret = config('services.boleto.bradesco.client_secret');
    }

    public function authenticate(): array
    {
        $client = new Client();

        $response = $client->post($this->apiUrl . '/auth/oauth/v2/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        return [
            'access_token' => $body['access_token'],
            'token_type' => $body['token_type'] ?? '',
            'expires_in' => $body['expires_in'],
            'active' => $body['active'] ?? '',
            'scope' => $body['scope'] ?? '',
        ];
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
