<?php

namespace App\Clients\Banks\Santander;

use App\Contracts\ApiBankSlipInterface;
use App\Exceptions\InvalidArgumentException;
use GuzzleHttp\Client;

class SantanderBoletoClient extends SantanderClient implements ApiBankSlipInterface
{

    public function __construct()
    {
        parent::__construct();
    }

    public function createBoleto(array $data): array
    {
        $client = new Client();

        $response = $client->post($this->apiUrl . '/collection_bill_management/v2/workspaces/'.$data['workspace_id'].'/bank_slips', [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Application-Key' => $this->clientId,
                'Authorization' => 'Bearer ' . $this->token,
            ],
            'json' => $data
        ]);

        $body = json_decode($response->getBody(), true);
        return $body;
    }

    public function cancelBoleto(string $boletoId): bool
    {
        return true;
    }

    public function getBoleto(string $boletoId): array
    {
        $dadosBoleto = [];
        return $dadosBoleto;
    }

    public function registerWebhook(string $url): bool
    {
        return true;
    }

    /**
     * generateDocument function
     *
     * @param string $payerDocumentNumber
     * @param string $billId
     *
     * @return array [link] URL para download do PDF do boleto
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function generateDocument(string $payerDocumentNumber, string $billId): array
    {
        if (empty($payerDocumentNumber) || empty($billId)) {
            throw new InvalidArgumentException('Número do documento do pagador e ID da cobrança são obrigatórios.');
        }
        if (strlen($payerDocumentNumber) < 11 || strlen($payerDocumentNumber) > 14) {
            throw new InvalidArgumentException('Número do documento do pagador inválido.');
        }
        if (strlen($billId) < 8 || strlen($billId) > 64) {
            throw new InvalidArgumentException('ID da cobrança é inválido.');
        }

        $client = new Client();
        $response = $client->post($this->apiUrl . '/collection_bill_management/v2/bills/'.$billId.'/bank_slips', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token,
            ],
            'json' => [
                'payerDocumentNumber' => $payerDocumentNumber,
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
