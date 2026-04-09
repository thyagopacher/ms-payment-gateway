<?php

namespace App\Services\Banks\Bradesco;

use App\Clients\Banks\Bradesco\BradescoClient;
use App\Contracts\BankInterface;
use Illuminate\Support\Facades\Log;

class BradescoService implements BankInterface
{

    public function getBankCode(): string
    {
        return 'bb';
    }

    public function getStatusConnectionApi(): bool
    {
        $client = new BradescoClient();
        try {
            $res = $client->auth();
            return !empty($res) && is_array($res) && isset($res['access_token']);
        } catch (\Throwable $e) {
            Log::error('Erro ao conectar com API do Bradesco: ' . $e->getMessage());
            return false;
        }
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
