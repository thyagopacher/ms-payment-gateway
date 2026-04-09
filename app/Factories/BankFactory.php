<?php

namespace App\Factories;

use App\Contracts\BankInterface;

class BankFactory
{
    public static function make(string $bank): BankInterface
    {
        return match ($bank) {
            'itau' => new \App\Services\Banks\Itau\ItauService(),
            'bradesco' => new \App\Services\Banks\Bradesco\BradescoService(),
            'bb' => new \App\Services\Banks\BancoDoBrasil\BancoDoBrasilService(),
            'santander' => new \App\Services\Banks\Santander\SantanderService(),
        };
    }
}
