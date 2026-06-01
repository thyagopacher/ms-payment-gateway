<?php

namespace App\Contracts;

interface PdfAdapterInterface
{
    public function generate(string $filename, string $content, array $options = []): string;
}
