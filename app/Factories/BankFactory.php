<?php

namespace App\Factories;

use App\Contracts\BankInterface;
use Illuminate\Support\Facades\Log;

class BankFactory
{
    public static function make(string $bank): BankInterface
    {
        Log::info("Creating bank service for bank: {$bank}");

        return match ($bank) {
            'itau' => new \App\Services\Banks\Itau\ItauService(),
            'bradesco' => new \App\Services\Banks\Bradesco\BradescoService(),
            'bb' => new \App\Services\Banks\BancoDoBrasil\BancoDoBrasilService(),
            'santander' => new \App\Services\Banks\Santander\SantanderService(),
            default => throw new \InvalidArgumentException("Bank {$bank} not implemented"),
        };
    }
}
