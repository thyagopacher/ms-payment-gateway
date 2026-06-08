<?php

namespace App\Services\Reports;

use App\Exceptions\NotFoundException;
use App\Http\Resources\PaymentResource;
use App\Repositories\PaymentRepository;
use App\Services\CsvService;

class OrderCsvReport
{
    public function __construct(
        private CsvService $csvService,
        private PaymentRepository $paymentRepository
    ) {

    }

    public function generate(array $filters): string
    {
        $payments = $this->paymentRepository->getPayments($filters);
        $rows = PaymentResource::collection($payments)->resolve();
        if (empty($rows)) {
            throw new NotFoundException('Nenhum pagamento encontrado para os filtros fornecidos.');
        }
        return $this->csvService->generate($rows);
    }

    public function filename(): string
    {
        return 'order_report.csv';
    }
}
