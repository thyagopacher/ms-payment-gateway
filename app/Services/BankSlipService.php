<?php

namespace App\Services;

use App\Contracts\BankSlipServiceInterface;
use App\Factories\BankFactory;
use App\Repositories\BankSlipRepository;

class BankSlipService implements BankSlipServiceInterface
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

    public function print(int $boletoId): string
    {
        $dadosBoleto = $this->bankSlipRepository->findBankSlipById($boletoId);
        if (empty($dadosBoleto)) {
            throw new \Exception('Boleto não encontrado.');
        }
        return BankFactory::make($dadosBoleto['bank'])->boleto()->print($boletoId);
    }
}
