<?php

namespace App\Services\Banks\BancoDoBrasil;

use App\Clients\Banks\BancoDoBrasil\BancoDoBrasilPixClient;
use App\Contracts\PixInterface;

class BancoDoBrasilPixService implements PixInterface
{

    private BancoDoBrasilPixClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new BancoDoBrasilPixClient();
    }

    public function generateQrCode(array $data): array
    {
        $dadosRetornoBanco = $this->apiBanco->generateQrCode($data);
        return $dadosRetornoBanco;
    }

}
