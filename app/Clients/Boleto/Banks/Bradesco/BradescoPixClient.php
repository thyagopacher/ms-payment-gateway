<?php

namespace App\Clients\Banks\Itau;

use App\Contracts\PixInterface;

class BradescoPixClient extends BradescoClient implements PixInterface
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
