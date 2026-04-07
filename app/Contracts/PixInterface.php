<?php

namespace App\Contracts;

interface PixInterface
{
    public function generateQrCode(array $data): array;

}
