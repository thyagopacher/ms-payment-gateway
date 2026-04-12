<?php

namespace App\Contracts;

interface PaymentMethodInterface
{
    public function create(array $data): array;

    public function getStatus(array $filters): array;

    public function cancel(array $data): bool;

    public function refund(array $data): bool;
}
