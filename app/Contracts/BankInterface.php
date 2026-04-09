<?php

namespace App\Contracts;

interface BankInterface
{
    public function getBankCode(): string;

    public function getStatusConnectionApi(): bool;

    public function boleto(): BoletoServiceInterface;

    public function pix(): PixInterface;
}
