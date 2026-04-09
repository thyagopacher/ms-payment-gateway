<?php

namespace App\Services\Banks\Santander;

use App\Clients\Banks\Santander\SantanderClient;
use App\Contracts\BankInterface;

class SantanderService implements BankInterface
{

    public function getBankCode(): string
    {
        return 'bb';
    }

    public function getStatusConnectionApi(): bool
    {
        $client = new SantanderClient();
        try {
            $res = $client->auth();
            return !empty($res) && is_array($res) && isset($res['access_token']);
        } catch (\Throwable $e) {
            return false;
        }
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

