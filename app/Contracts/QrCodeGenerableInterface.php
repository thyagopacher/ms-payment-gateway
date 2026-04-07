<?php

namespace App\Contracts;

interface QrCodeGenerableInterface
{
    public function generateQrCode(): string;
}
