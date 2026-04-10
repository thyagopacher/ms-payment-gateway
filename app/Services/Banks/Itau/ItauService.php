<?php

namespace App\Services\Banks\Itau;

use App\Clients\Banks\Itau\ItauClient;
use App\Contracts\BankInterface;
use Illuminate\Support\Facades\Log;

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
            return !empty($res) && !empty($res['access_token']);
        } catch (\Throwable $e) {
            Log::error('Erro ao conectar com API do Itau: ' . $e->getMessage());
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
