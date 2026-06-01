<?php

namespace App\Services\Reports;

use App\Contracts\PdfAdapterInterface;

class MpdfAdapter implements PdfAdapterInterface
{
    public function generate(string $filename, string $content, array $options = []): string
    {
        $mpdf = new \Mpdf\Mpdf($options);
        $mpdf->WriteHTML($content);

        return $mpdf->Output($filename, 'S');
    }
}
