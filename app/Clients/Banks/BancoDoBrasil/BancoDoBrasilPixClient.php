<?php

namespace App\Clients\Banks\BancoDoBrasil;

use App\Contracts\PixInterface;
use GuzzleHttp\Client;

class BancoDoBrasilPixClient extends BancoDoBrasilClient implements PixInterface
{

    public function __construct()
    {
        parent::__construct();
    }


    public function generateQrCode(array $data): array
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

}
