<?php

namespace App\Services;

class PdfService
{
    /**
     * generatePdf function
     *
     * @param string $html
     * @return string source code pdf gerado
     *
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function generatePdf(string $html): string
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('', 'S'); // Retorna o PDF como string
    }
}
