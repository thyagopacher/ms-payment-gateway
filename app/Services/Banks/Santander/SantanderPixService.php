<?php

namespace App\Services\Banks\Santander;

use App\Clients\Banks\Santander\SantanderPixClient;
use App\Contracts\PixInterface;

class SantanderPixService implements PixInterface
{

    private SantanderPixClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new SantanderPixClient();
    }

    public function generateQrCode(array $data): array
    {
        $dadosRetornoBanco = [];
        return $dadosRetornoBanco;
    }

}
