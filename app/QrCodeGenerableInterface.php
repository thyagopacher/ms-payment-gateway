<?php

namespace App;

interface QrCodeGenerableInterface
{
    public function generateQrCode(): string;
}
