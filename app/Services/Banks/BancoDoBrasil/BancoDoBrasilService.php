<?php

namespace App\Services\Banks\BancoDoBrasil;

use App\Contracts\BankInterface;
use App\Contracts\BoletoServiceInterface;

class BancoDoBrasilService implements BankInterface
{

    public function getBankCode(): string
    {
        return 'bb';
    }

    public function boleto(): BancoDoBrasilBoletoService
    {
        return new BancoDoBrasilBoletoService();
    }

    public function pix(): BancoDoBrasilPixService
    {
        return new BancoDoBrasilPixService();
    }
}
