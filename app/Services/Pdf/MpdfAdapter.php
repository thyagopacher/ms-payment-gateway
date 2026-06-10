<?php

namespace App\Services\Pdf;

use App\Contracts\PdfAdapterInterface;

class MpdfAdapter implements PdfAdapterInterface
{
    public function generate(string $filename, string $content, array $options = []): string
    {
        $options['tempDir'] = storage_path('app/mpdf');

        $mpdf = new \Mpdf\Mpdf($options);
        $mpdf->WriteHTML($content);

        return $mpdf->Output($filename, 'S');
    }
}
