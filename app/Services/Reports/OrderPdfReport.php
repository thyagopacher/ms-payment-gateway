<?php

namespace App\Services\Reports;

use App\Repositories\PaymentRepository;
use App\Services\Pdf\PdfService;
use Illuminate\Database\Eloquent\Collection;

class OrderPdfReport
{
    public function __construct(
        private PdfService $pdfService,
        private OrderDataReport $orderData
    ) {

    }

    public function generate(array $filters): string
    {
        $filename = 'order_report.pdf';
        $payments = $this->orderData->find($filters);

        $content = view('reports.orders', ['payments' => $payments])->render();
        if (!empty($filters['totals'])) {
            $content = view('reports.orders_totals', ['payments' => $payments])->render();
        }

        return $this->pdfService->generate($filename, $content);
    }

    public function filename(): string
    {
        return 'order_report.pdf';
    }
}
