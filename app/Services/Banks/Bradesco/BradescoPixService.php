<?php

namespace App\Services\Banks\Bradesco;

use App\Clients\Banks\Bradesco\BradescoPixClient;
use App\Contracts\PixInterface;

class BradescoPixService implements PixInterface
{

    private BradescoPixClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new BradescoPixClient();
    }

    public function generateQrCode(array $data): array
    {
        $dadosRetornoBanco = [];
        return $dadosRetornoBanco;
    }

}
