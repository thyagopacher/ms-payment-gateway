<?php

namespace App\Services\Payment;

use App\Clients\StripeApiClient;
use App\DTO\CreateChargeDTO;

class StripeService
{
    public function __construct(
        private StripeApiClient $stripeClient
    ) {
    }

    /**
     * Cria uma cobrança.
     *
     * @param CreateChargeDTO $dto DTO contendo os dados necessários para criar a cobrança.
     *
     * @return object Detalhes da cobrança criada.
     */
    public function createCharge(CreateChargeDTO $dto): object {
        return $this->stripeClient->createCharge($dto->toArray());
    }

    /**
     * Consulta uma cobrança.
     *
     * @param string $chargeId ID da cobrança a ser consultada.
     * @return object Detalhes da cobrança.
     */
    public function getCharge(string $chargeId): object
    {
        return $this->stripeClient->retrieveCharge($chargeId);
    }

    /**
     * Lista cobranças.
     *
     * @param int $limit Quantidade máxima de cobranças a serem listadas.
     */
    public function listCharges(int $limit = 10): object
    {
        return $this->stripeClient->listCharges([
            'limit' => $limit,
        ]);
    }

    /**
     * Captura uma cobrança previamente autorizada.
     *
     * @param string $chargeId ID da cobrança a ser capturada.
     * @return object Detalhes da cobrança capturada.
     */
    public function captureCharge(string $chargeId): object
    {
        return $this->stripeClient->captureCharge($chargeId);
    }

    /**
     * Atualiza informações da cobrança.
     */
    public function updateCharge(
        string $chargeId,
        array $metadata
    ): object {
        return $this->stripeClient->updateCharge(
            $chargeId,
            [
                'metadata' => $metadata,
            ]
        );
    }

    /**
     * Realiza reembolso total.
     *
     * @param string $chargeId ID da cobrança a ser reembolsada.
     * @return object Detalhes do reembolso criado.
     */
    public function refundCharge(string $chargeId): object
    {
        return $this->stripeClient->createRefund([
            'charge' => $chargeId,
        ]);
    }

    /**
     * Realiza reembolso parcial.
     *
     * @param string $chargeId ID da cobrança a ser reembolsada.
     * @param int $amount Valor em centavos a ser reembolsado.
     * @return object Detalhes do reembolso criado.
     */
    public function partialRefundCharge(
        string $chargeId,
        int $amount
    ): object {
        return $this->stripeClient->createRefund([
            'charge' => $chargeId,
            'amount' => $amount,
        ]);
    }

    /**
     * Consulta um reembolso.
     *
     * @param string $refundId ID do reembolso a ser consultado.
     * @return object Detalhes do reembolso.
     */
    public function getRefund(string $refundId): object
    {
        return $this->stripeClient->retrieveRefund($refundId);
    }
}
