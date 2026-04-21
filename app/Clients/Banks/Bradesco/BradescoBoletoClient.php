<?php

namespace App\Clients\Banks\Bradesco;

use App\Contracts\ApiBankSlipInterface;
use GuzzleHttp\Client;

class BradescoBoletoClient extends BradescoClient implements ApiBankSlipInterface
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

    /**
     * cancelBankSlip function
     *
     * @param string $boletoId
     * @return boolean
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function cancelBankSlip (array $data): array
    {
        $client = new Client();

        $response = $client->post($this->apiUrl . '/boleto/cobranca-baixa/v1/baixar', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token,
            ],
            'json' => array_merge([
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ], $data)
        ]);

        $body = json_decode($response->getBody(), true);
        return $body;
    }

    public function getBankSlip(array $filters): array
    {
        $client = new Client();

        $response = $client->post($this->apiUrl . '/boleto-hibrido/cobranca-consulta-titulo/v1/consultar', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token,
            ],
            'json' => array_merge([
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ], $filters)
        ]);

        $body = json_decode($response->getBody(), true);
        return $body;
    }

    /**
     * registerWebhook function
     * Exemplo:
     * {
     *   "tipoAviso": 0,
     *   "documento": {
     *     "filial": "9999",
     *     "cpfCnpj": "999999999",
     *     "controle": "99"
     *   },
     *   "utilizaWebhook": "S",
     *   "tipoCadastro": "I",
     *   "versaoLayout": "1",
     *   "urlEnvio": "https://dominio.com.br/webhook"
     * }
     * @param array $data
     * @return array
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function registerWebhook (array $data): array
    {
        $client = new Client();

        $response = $client->post($this->apiUrl . '/boleto/cobranca-webhook/v1/cadastrar', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token,
            ],
            'json' => array_merge([
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ], $data)
        ]);

        $body = json_decode($response->getBody(), true);
        return $body;
    }
}
