<?php

namespace App\Services\Banks\Santander;

use App\Clients\Banks\Santander\SantanderClient;
use App\Contracts\BankInterface;
use Illuminate\Support\Facades\Log;

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
            return !empty($res) && !empty($res['access_token']);
        } catch (\Throwable $e) {
            Log::error('Erro ao conectar com API do Santander: ' . $e->getMessage());
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

