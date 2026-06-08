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
     * createBankSlip function
     *
     * Ex: https://pix-pj.api.itau.com/recebimentos-pix/v1/boletos-pix
     *
     * @param array $data
     * @return array
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function createBankSlip(array $data): array
    {
        $client = new Client();

        $headers = array_merge($this->headersAuth, [
            'Content-Type' => 'application/json',
        ]);
        $response = $client->post($this->apiUrl . '/recebimentos-pix/v1/boletos-pix', [
            'headers' => $headers,
            'json' => array_merge([
                'grant_type' => 'client_credentials',
            ], $data)
        ]);

        $body = json_decode($response->getBody(), true);
        return $body;
    }

    /**
     * cancelBankSlip function
     *
     * Ex: https://api.itau.com.br/cash_management/v2/boletos/{id_boleto}/baixa
     *
     * @param array $data
     * @return array
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function cancelBankSlip(array $data): array
    {
        $client = new Client();

        $headers = array_merge($this->headersAuth, [
            'Content-Type' => 'application/json',
        ]);
        $response = $client->patch($this->apiUrl . '/cash_management/v2/boletos/' . $data['boletoId'] . '/baixa', [
            'headers' => $headers,
            'json' => array_merge([
                'grant_type' => 'client_credentials',
            ], $data)
        ]);

        $body = json_decode($response->getBody(), true);
        return $body;
    }

    /**
     * getBoleto function
     * Ex: https://boleto.api.itau.com/boleto/v1/boletos
     *
     * @param array $filters
     * @return array
     */
    public function getBankSlip(array $filters): array
    {
        // implementação de consulta de boleto para Banco do Brasil
        $dadosBoleto = [];
        return $dadosBoleto;
    }

    /**
     * registerWebhook function
     *
     * Ex: https://boletos.cloud.itau.com.br/boletos/v3/notificacoes_boletos
     *
     * @param array $data
     * @return array
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function registerWebhook(array $data): array
    {
        $data = [
            'id_beneficiario' => 150000154711,
            'webhook_url' => 'https://teste1.webhook.com',
            'webhook_client_id' => $this->clientId,
            'webhook_client_secret' => $this->clientSecret,
            'webhook_oauth_url' => 'https://auth.webhook.com',
            'webhook_oauth_scope' => 'boletos-notificacao',
            'valor_minimo' => 1575.15,
            'tipos_notificacoes' => [
                'BAIXA_EFETIVA',
                'BAIXA_OPERACIONAL'
            ]
        ];

        $client = new Client();

        $headers = array_merge($this->headersAuth, [
            'Content-Type' => 'application/json',
        ]);
        $response = $client->post($this->apiUrl . '/boletos/v3/notificacoes_boletos', [
            'headers' => $headers,
            'json' => array_merge([
                'grant_type' => 'client_credentials',
            ], $data)
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getWebhooks(string $id_beneficiario): array
    {
        $client = new Client();

        $headers = array_merge($this->headersAuth, [
            'Content-Type' => 'application/json',
        ]);

        $url = $this->apiUrl . '/boletos/v3/notificacoes_boletos?id_beneficiario=' . $id_beneficiario;
        $response = $client->get($url, [
            'headers' => $headers,
            'json' => array_merge([
                'grant_type' => 'client_credentials',
            ])
        ]);

        return json_decode($response->getBody(), true);
    }

    public function deleteWebhook(string $id_notificacao_boleto): array
    {
        $client = new Client();

        $headers = array_merge($this->headersAuth, [
            'Content-Type' => 'application/json',
        ]);

        $url = $this->apiUrl . '/boletos/v3/notificacoes_boletos/' . $id_notificacao_boleto;
        $response = $client->delete($url, [
            'headers' => $headers,
            'json' => array_merge([
                'grant_type' => 'client_credentials',
            ])
        ]);

        return json_decode($response->getBody(), true);
    }

    public function updateWebhook(string $id_notificacao_boleto, array $data): array
    {
        $client = new Client();

        $headers = array_merge($this->headersAuth, [
            'Content-Type' => 'application/json',
        ]);

        $data = [
            'webhook_client_id' => $this->clientId,
            'webhook_client_secret' => $this->clientSecret,
            'webhook_url' => 'https://teste1.webhook.com',
            'webhook_oauth_url' => 'https://auth.webhook.com',
            'webhook_oauth_scope' => 'boletos-notificacoes',
            'valor_minimo' => 1575.15
        ];

        $url = $this->apiUrl . '/boletos/v3/notificacoes_boletos/' . $id_notificacao_boleto;
        $response = $client->patch($url, [
            'headers' => $headers,
            'json' => array_merge([
                'data' => $data,
            ])
        ]);

        return json_decode($response->getBody(), true);
    }
}
