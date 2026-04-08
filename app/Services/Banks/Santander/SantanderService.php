<?php

namespace App\Services\Banks\Santander;

use App\Contracts\BankInterface;

class SantanderService implements BankInterface
{

    public function getBankCode(): string
    {
        return 'bb';
    }

    public function boleto(): SantanderBoletoService
    {
        return new SantanderBoletoService();
    }

    public function pix(): SantanderPixService
    {
        return new SantanderPixService();
    }
}

