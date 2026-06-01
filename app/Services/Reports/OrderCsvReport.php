<?php

namespace App\Services\Reports;

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
        $content = $payments->toArray();
        return $this->csvService->generate($content);
    }

}
