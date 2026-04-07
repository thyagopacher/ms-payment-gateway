<?php

namespace App\Services;

use App\Services\Boleto\BancoDoBrasilService;
use App\Services\Boleto\ItauService;
use App\Services\Boleto\BradescoService;
use App\Services\Boleto\SantanderService;

class BoletoService
{
    public function resolveBank($bank)
    {
        return match ($bank) {
            'itau' => new ItauService(),
            'bradesco' => new BradescoService(),
            'bb' => new BancoDoBrasilService(),
            'santander' => new SantanderService(),
        };
    }
}
