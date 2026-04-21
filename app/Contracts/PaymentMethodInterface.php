<?php

namespace App\Contracts;

interface PaymentMethodInterface
{
    public function create(array $data): array;

    public function cancel(array $data): array;

}
