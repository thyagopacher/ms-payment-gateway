<?php

namespace App\Factories;

use App\Contracts\PaymentMethodInterface;
use Illuminate\Support\Facades\Log;

class PaymentMethodFactory
{
    public static function make(string $paymentMethod): PaymentMethodInterface
    {
        Log::info("Creating payment method service for: ". $paymentMethod);

        return match ($paymentMethod) {
            'pix' => app(\App\Services\PixService::class),
            'bank_slip' => app(\App\Services\BankSlipService::class),
            'credit_card' => app(\App\Services\CreditCardService::class),
            default => throw new \InvalidArgumentException("Payment method {$paymentMethod} not implemented"),
        };
    }
}
