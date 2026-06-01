<?php

namespace App\Services;

use App\Contracts\PdfAdapterInterface;

class PdfService
{
    public function __construct(private PdfAdapterInterface $adapterPdf)
    {

    }

    public function generate(string $filename, string $content, array $options = []): string
    {
        return $this->adapterPdf->generate($filename, $content, $options);
    }
}
