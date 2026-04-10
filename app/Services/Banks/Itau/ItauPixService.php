<?php

namespace App\Services\Banks\Itau;

use App\Clients\Banks\Itau\ItauPixClient;
use App\Contracts\PixInterface;

class ItauPixService implements PixInterface
{

    private ItauPixClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new ItauPixClient();
    }

    public function generateQrCode(array $data): array
    {
        $dadosRetornoBanco = $this->apiBanco->generateQrCode($data);
        return $dadosRetornoBanco;
    }

}
