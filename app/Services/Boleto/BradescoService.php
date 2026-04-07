<?php

namespace App\Services\Boleto;

use App\Contracts\BoletoServiceInterface;

class BradescoService extends BoletoServiceInterface
{
    public function create(array $data): array
    {
        $dadosRetornoBanco = [];
        return $dadosRetornoBanco;
    }

    public function print(int $boletoId): string
    {
        // lógica para imprimir boleto do Banco do Brasil
        return "Boleto do Banco do Brasil impresso com ID: {$boletoId}";
    }
}
