<?php

namespace Tests\Unit\Factories;

class BankFactoryTest extends \Tests\TestCase
{
    public function test_make_itau(): void
    {
        $bank = \App\Factories\BankFactory::make('itau');
        $this->assertInstanceOf(\App\Services\Banks\Itau\ItauService::class, $bank);
    }

    public function test_make_bradesco(): void
    {
        $bank = \App\Factories\BankFactory::make('bradesco');
        $this->assertInstanceOf(\App\Services\Banks\Bradesco\BradescoService::class, $bank);
    }

    public function test_make_bb(): void
    {
        $bank = \App\Factories\BankFactory::make('bb');
        $this->assertInstanceOf(\App\Services\Banks\BancoDoBrasil\BancoDoBrasilService::class, $bank);
    }

    public function test_make_santander(): void
    {
        $bank = \App\Factories\BankFactory::make('santander');
        $this->assertInstanceOf(\App\Services\Banks\Santander\SantanderService::class, $bank);
    }

    public function test_make_invalid_bank(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        \App\Factories\BankFactory::make('invalid_bank');
    }
}
