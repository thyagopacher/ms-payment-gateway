<?php

namespace App\Services\Banks\BancoDoBrasil;

use App\Clients\Banks\BancoDoBrasil\BancoDoBrasilClient;
use App\Contracts\BankInterface;

class BancoDoBrasilService implements BankInterface
{

    public function getBankCode(): string
    {
        return 'bb';
    }

    public function getStatusConnectionApi(): bool
    {
        $client = new BancoDoBrasilClient();
        try {
            $res = $client->auth();
            return !empty($res) && is_array($res) && isset($res['access_token']);
        } catch (\Throwable $e) {
            return false;
        }
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
