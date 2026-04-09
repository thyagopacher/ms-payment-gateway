<?php

namespace App\Services\Banks\Itau;

use App\Clients\Banks\Itau\ItauClient;
use App\Contracts\BankInterface;

class ItauService implements BankInterface
{

    public function getBankCode(): string
    {
        return 'bb';
    }

    public function getStatusConnectionApi(): bool
    {
        $client = new ItauClient();
        try {
            $res = $client->auth();
            return !empty($res) && is_array($res) && isset($res['access_token']);
        } catch (\Throwable $e) {
            return false;
        }
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
