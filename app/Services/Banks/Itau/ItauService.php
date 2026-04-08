<?php

namespace App\Services\Banks\Itau;

use App\Contracts\BankInterface;

class ItauService implements BankInterface
{

    public function getBankCode(): string
    {
        return 'bb';
    }

    public function boleto(): ItauBoletoService
    {
        return new ItauBoletoService();
    }

    public function pix(): ItauPixService
    {
        return new ItauPixService();
    }
}
