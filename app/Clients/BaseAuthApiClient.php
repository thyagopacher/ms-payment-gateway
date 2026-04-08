<?php

namespace App\Clients;

use GuzzleHttp\Client;

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
        $client = new Client();

        $response = $client->post($this->apiUrl . $endpoint, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
