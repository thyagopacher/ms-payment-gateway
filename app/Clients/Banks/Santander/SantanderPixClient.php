<?php

namespace App\Clients\Banks\Santander;

use App\Contracts\PixInterface;

class SantanderPixClient extends SantanderClient implements PixInterface
{

    public function __construct()
    {
        parent::__construct();
    }


    public function generateQrCode(array $data): array
    {
        // implementação de criação de boleto para Banco do Brasil
        $dadosRetornoBanco = [];
        return $dadosRetornoBanco;
    }

}
