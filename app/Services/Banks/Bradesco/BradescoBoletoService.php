<?php

namespace App\Services\Banks\Bradesco;

use App\Clients\Banks\Bradesco\BradescoBoletoClient;
use App\Contracts\BoletoServiceInterface;
use App\Services\PdfService;

class BradescoBoletoService implements BoletoServiceInterface
{

    protected BradescoBoletoClient $apiBanco;

    public function __construct()
    {
        $this->apiBanco = new BradescoBoletoClient();
    }

    public function create(array $data): array
    {
        return $this->apiBanco->createBoleto($data);
    }

    public function print(int $boletoId): string
    {
        //0 - obter dados do boleto, incluindo o banco
        $boletoData = [];
        
        //1 - gerar HTML do boleto
        $htmlContent = '';

        //2 - converter HTML para PDF
        $pdfService = new PdfService();
        $pdfContent = $pdfService->generatePdf($htmlContent);
        return $pdfContent;
    }
}
