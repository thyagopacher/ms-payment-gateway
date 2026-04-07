<?php

namespace App\Contracts;

interface PaymentMethodInterface
{
    public function pay(): bool;
}
