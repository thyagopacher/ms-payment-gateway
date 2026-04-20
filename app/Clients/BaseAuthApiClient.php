<?php

namespace App\Clients;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

abstract class BaseAuthApiClient
{

    protected string $apiUrl = '';
    protected string $clientId = '';
    protected string $clientSecret = '';
    protected string $token = '';
    protected int $expiresIn = 0;
    protected array $headersAuth = [];

    public function __construct() {

    }

    public function authenticate(string $endpoint, array $certs = []): array
    {
        $enderecoUrl = $this->apiUrl . $endpoint;
        Log::info("Realizando autenticação na API: ".$enderecoUrl);

        $client = new Client();

        $options = [
            'http_errors' => false,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]
        ];
        if (!empty($certs)) {
            Log::info("Utilizando certificados para autenticação.");
            $options = array_merge($options, $certs);
        }

        $response = $client->post($enderecoUrl, $options);

        $returnJson = json_decode($response->getBody(), true);
        if ($response->getStatusCode() !== 200) {
            $msgException = "Erro na autenticação da API: HttpCode " . $response->getStatusCode();
            Log::error($msgException . " - " . $response->getBody());
            throw new \Exception($msgException);
        }

        return $returnJson;
    }
}
