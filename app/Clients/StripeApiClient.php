<?php

namespace App\Clients;

use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class StripeApiClient
{

    private StripeClient $stripe;

    public function __construct(
        private string $apiKey
    ) {
        $this->stripe = new \Stripe\StripeClient($apiKey);
    }

    /**
     * Cria uma cobrança (Charge).
     *
     * @throws ApiErrorException
     */
    public function createCharge(array $data): object
    {
        return $this->stripe->charges->create($data);
    }

    /**
     * Busca uma cobrança pelo ID.
     *
     * @throws ApiErrorException
     */
    public function retrieveCharge(string $chargeId): object
    {
        return $this->stripe->charges->retrieve($chargeId);
    }

    /**
     * Lista cobranças.
     *
     * @throws ApiErrorException
     */
    public function listCharges(array $params = []): object
    {
        return $this->stripe->charges->all($params);
    }

    /**
     * Captura uma cobrança autorizada.
     *
     * @throws ApiErrorException
     */
    public function captureCharge(string $chargeId, array $params = []): object
    {
        return $this->stripe->charges->capture($chargeId, $params);
    }

    /**
     * Atualiza uma cobrança.
     *
     * @throws ApiErrorException
     */
    public function updateCharge(string $chargeId, array $data): object
    {
        return $this->stripe->charges->update($chargeId, $data);
    }

    /**
     * Cria um reembolso.
     *
     * @throws ApiErrorException
     */
    public function createRefund(array $data): object
    {
        return $this->stripe->refunds->create($data);
    }

    /**
     * Busca um reembolso.
     *
     * @throws ApiErrorException
     */
    public function retrieveRefund(string $refundId): object
    {
        return $this->stripe->refunds->retrieve($refundId);
    }
}
