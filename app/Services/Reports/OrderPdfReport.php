<?php

namespace App\Services\Reports;

use App\Repositories\PaymentRepository;
use App\Services\PdfService;
use Illuminate\Database\Eloquent\Collection;

class OrderPdfReport
{
    public function __construct(
        private PdfService $pdfService,
        private PaymentRepository $paymentRepository
    ) {

    }

    public function generate(array $filters): string
    {
        $filename = 'order_report.pdf';
        $payments = $this->paymentRepository->getPayments($filters);
        $content = $this->generateContent($payments);
        return $this->pdfService->generate($filename, $content);
    }

    private function generateContent(Collection $payments): string
    {
        $html = view(
            'reports.orders',
            ['payments' => $payments]
        )->render();
        return $html;
    }
}
