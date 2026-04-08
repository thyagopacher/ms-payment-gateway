<?php

namespace App\Services;

use App\Contracts\QrCodeGenerableInterface;
use App\Factories\BankFactory;

class PixService implements QrCodeGenerableInterface
{

    public function generateQrCode(array $data): string
    {
        $qrcode = BankFactory::make($data['bank'])->pix()->generateQrCode($data);
        return $qrcode['qrcode'];
    }
}
