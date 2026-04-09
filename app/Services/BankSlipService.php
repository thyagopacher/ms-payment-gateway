<?php

namespace App\Services;

use App\Contracts\BoletoServiceInterface;
use App\Factories\BankFactory;
use App\Models\BankSlip;

class BankSlipService implements BoletoServiceInterface
{
    public function create(array $data): array
    {
        return BankFactory::make($data['bank'])->boleto()->create($data);
    }

    public function print(int $boletoId): string
    {
        $dadosBoleto = BankSlip::find($boletoId);
        if (empty($dadosBoleto)) {
            throw new \Exception('Boleto não encontrado.');
        }
        return BankFactory::make($dadosBoleto['bank'])->boleto()->print($boletoId);
    }
}
