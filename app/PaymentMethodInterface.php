<?php

namespace App;

interface PaymentMethodInterface
{
    public function pay(): bool;
}
