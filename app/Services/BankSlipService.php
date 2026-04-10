<?php

namespace App\Services;

use App\Contracts\BoletoServiceInterface;
use App\Factories\BankFactory;
use App\Repositories\BankSlipRepository;

class BankSlipService implements BoletoServiceInterface
{

    public function __construct(private BankSlipRepository $bankSlipRepository)
    {

    }

    public function create(array $data): array
    {
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
