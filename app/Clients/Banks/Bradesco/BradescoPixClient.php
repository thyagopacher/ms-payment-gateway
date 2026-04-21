<?php

namespace App\Clients\Banks\Bradesco;

use App\Contracts\PixInterface;
use GuzzleHttp\Client;

class BradescoPixClient extends BradescoClient implements PixInterface
{

    public function __construct()
    {
        parent::__construct();

        $this->headersAuth['Authorization'] = 'Bearer ' . $this->getToken();
    }


    public function generateBilling(array $data): array
    {
        $client = new Client();

        $headers = array_merge($this->headersAuth, [
            'Content-Type' => 'application/json',
        ]);
        $response = $client->post($this->apiUrl . '/cob', [
            'headers' => $headers,
            'json' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        return $body;
    }

    /**
     * recurrenceBilling function
     *
     * Ex: https://recebimentos-pix.api.itau.com/qrcode-pix-automatico/v1/cobrancas
     *
     * @param array $data
     * @return array
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function recurrenceBilling(array $data): array
    {
        $client = new Client();

        $headers = array_merge($this->headersAuth, [
            'Content-Type' => 'application/json',
        ]);
        $response = $client->post($this->apiUrl . '/qrcode-pix-automatico/v1/cobrancas', [
            'headers' => $headers,
            'json' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]
        ]);

        $body = json_decode($response->getBody(), true);
        return $body;
    }

    /**
     * cancelRecurrenceBilling function
     *
     * Ex: https://recebimentos-pix.api.itau.com/qrcode-pix-automatico/v1/cobrancas/{cobrancaId}
     *
     * @param array $data
     * @return array
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function cancelRecurrenceBilling(array $data): array
    {
        $client = new Client();

        $headers = array_merge($this->headersAuth, [
            'Content-Type' => 'application/json',
        ]);
        $response = $client->patch($this->apiUrl . '/qrcode-pix-automatico/v1/cobrancas/' . $data['cobrancaId'], [
            'headers' => $headers,
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
