<?php

namespace App\Services;

use App\Contracts\BankSlipInterface;
use App\Contracts\PaymentMethodInterface;
use App\Factories\BankFactory;
use App\Repositories\BankSlipRepository;

class BankSlipService implements BankSlipInterface, PaymentMethodInterface
{

    public function __construct(private BankSlipRepository $bankSlipRepository)
    {

    }

    public function create(array $data): array
    {
        if (empty($data['bank'])) {
            throw new \Exception('Banco é obrigatório para criar o boleto.');
        }
        return BankFactory::make($data['bank'])->boleto()->create($data);
    }

    public function getStatus(array $filters): array
    {
        // Implementação da obtenção do status do pagamento com cartão de crédito
        return ['status' => 'pending']; // Retorna um array com o status do pagamento
    }

    public function cancel(array $data): bool
    {
        // Implementação do cancelamento do pagamento com cartão de crédito
        return true; // Retorna true se o cancelamento for bem-sucedido
    }

    public function refund(array $data): bool
    {
        // Implementação do reembolso do pagamento com cartão de crédito
        return true; // Retorna true se o reembolso for bem-sucedido
    }

    public function print(int $boletoId): string
    {
        $dadosBoleto = $this->bankSlipRepository->findBankSlipById($boletoId);
        if (empty($dadosBoleto)) {
            throw new \Exception('Boleto não encontrado.');
        }
        return BankFactory::make($dadosBoleto['bank'])->boleto()->print($boletoId);
    }
}
