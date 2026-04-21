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

        $boleto = BankFactory::make($data['bank'])->boleto();
        return $boleto->create($data);
    }

    public function cancel(array $data): array
    {
        $boleto = BankFactory::make($data['bank'])->boleto();
        $data = $boleto->cancel($data);
        return $data;
    }

    public function getBankSlip(array $data): array
    {
        $boleto = BankFactory::make($data['bank'])->boleto();
        $data = $boleto->getBankSlip($data);
        return $data;
    }

    public function print(int $boletoId): string
    {
        $dadosBoleto = $this->bankSlipRepository->findBankSlipById($boletoId);
        if (empty($dadosBoleto)) {
            throw new \Exception(__('select_not_found'), 404);
        }
        return BankFactory::make($dadosBoleto['bank'])->boleto()->print($boletoId);
    }
}
