<?php

namespace App\Services\Bank\Boleto;

use App\Contracts\BoletoServiceInterface;
use App\Factories\BankFactory;

class BoletoService implements BoletoServiceInterface
{
    public function create(array $data): array
    {
        return BankFactory::make($data['bank'])->boleto()->create($data);
    }

    public function print(int $boletoId): string
    {
        $dadosBoleto = []; // lógica para obter dados do boleto, incluindo o banco
        return BankFactory::make($dadosBoleto['bank'])->boleto()->print($boletoId);
    }
}
