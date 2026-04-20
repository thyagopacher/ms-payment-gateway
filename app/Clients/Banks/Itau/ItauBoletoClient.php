<?php

namespace App\Clients\Banks\Itau;

use App\Contracts\ApiBankSlipInterface;
use GuzzleHttp\Client;

class ItauBoletoClient extends ItauClient implements ApiBankSlipInterface
{

    public function __construct()
    {
        parent::__construct();

        $this->headersAuth['Authorization'] = 'Bearer ' . $this->getToken();
    }


    /**
     * createBoleto
     *
     * Ex: https://pix-pj.api.itau.com/recebimentos-pix/v1/boletos-pix
     *
     * @param array $data
     * @return array
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function createBoleto(array $data): array
    {
        $client = new Client();

        $headers = array_merge($this->headersAuth, [
            'Content-Type' => 'application/json',
        ]);
        $response = $client->post($this->apiUrl . '/recebimentos-pix/v1/boletos-pix', [
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
     * cancelBoleto function
     *
     * Ex: https://api.itau.com.br/cash_management/v2/boletos/{id_boleto}/baixa
     *
     * @param string $boletoId
     * @return boolean
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function cancelBoleto(string $boletoId): bool
    {
        $client = new Client();

        $headers = array_merge($this->headersAuth, [
            'Content-Type' => 'application/json',
        ]);
        $response = $client->patch($this->apiUrl . '/cash_management/v2/boletos/' . $boletoId . '/baixa', [
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
     * getBoleto function
     * Ex: https://boleto.api.itau.com/boleto/v1/boletos
     *
     * @param string $boletoId
     * @return array
     */
    public function getBoleto(string $boletoId): array
    {
        // implementação de consulta de boleto para Banco do Brasil
        $dadosBoleto = [];
        return $dadosBoleto;
    }

    /**
     * Undocumented function
     *
     * Ex: https://boletos.cloud.itau.com.br/boletos/v3/notificacoes_boletos
     *
     * @param string $url
     * @return boolean
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function registerWebhook(string $url): bool
    {
        $client = new Client();

        $headers = array_merge($this->headersAuth, [
            'Content-Type' => 'application/json',
        ]);
        $response = $client->post($this->apiUrl . '/boletos/v3/notificacoes_boletos', [
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
