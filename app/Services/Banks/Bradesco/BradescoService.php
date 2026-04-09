<?php

namespace App\Services\Banks\Bradesco;

use App\Clients\Banks\Bradesco\BradescoClient;
use App\Contracts\BankInterface;

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
