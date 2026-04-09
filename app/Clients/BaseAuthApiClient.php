<?php

namespace App\Clients;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

abstract class BaseAuthApiClient
{

    public function __construct(
        private string $apiUrl,
        private string $clientId,
        private string $clientSecret
    ) {

    }

    public function authenticate(string $endpoint): array
    {
        $enderecoUrl = $this->apiUrl . $endpoint;
        Log::info("Realizando autenticação na API: ".$enderecoUrl);

        $client = new Client();

        $response = $client->post($enderecoUrl, [
            'http_errors' => false,
            'ssl_key' => [storage_path('certs/certificado.pem'), env('SENHA_CERTIFICADO')],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]
        ]);

        $returnJson = json_decode($response->getBody(), true);
        if ($response->getStatusCode() !== 200) {
            $msgException = "Erro na autenticação da API: HttpCode " . $response->getStatusCode();
            Log::error($msgException . " - " . $response->getBody());
            throw new \Exception($msgException);
        }

        return $returnJson;
    }
}
