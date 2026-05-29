<?php

namespace Tests\Unit\Factories;

use App\Services\Payment\BankSlipService;
use App\Services\Payment\CreditCardService;
use App\Services\Payment\PixService;

class PaymentMethodFactoryTest extends \Tests\TestCase
{
    public function test_make_itau(): void
    {
        $bank = \App\Factories\PaymentMethodFactory::make('pix');
        $this->assertInstanceOf(PixService::class, $bank);
    }

    public function test_make_bradesco(): void
    {
        $bank = \App\Factories\PaymentMethodFactory::make('bank_slip');
        $this->assertInstanceOf(BankSlipService::class, $bank);
    }

    public function test_make_bb(): void
    {
        $bank = \App\Factories\PaymentMethodFactory::make('credit_card');
        $this->assertInstanceOf(CreditCardService::class, $bank);
    }

    public function test_make_invalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        \App\Factories\PaymentMethodFactory::make('invalid');
    }
}
