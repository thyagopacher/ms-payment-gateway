<?php

namespace App\Services\Banks\Bradesco;

use App\Contracts\BankInterface;

class BradescoService implements BankInterface
{

    public function getBankCode(): string
    {
        return 'bb';
    }

    public function boleto(): BradescoBoletoService
    {
        return new BradescoBoletoService();
    }

    public function pix(): BradescoPixService
    {
        return new BradescoPixService();
    }
}
