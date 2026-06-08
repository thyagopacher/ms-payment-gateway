<?php

namespace App\Services\Reports;

use App\Repositories\PaymentRepository;
use Illuminate\Database\Eloquent\Collection;

class OrderDataReport
{

    public function __construct(private PaymentRepository $paymentRepository)
    {

    }

    public function find(array $filters): Collection
    {
        if (!empty($filters['totals'])) {
            return $this->paymentRepository->getTotalsPayments($filters);
        }
        return $this->paymentRepository->getPayments($filters);
    }

}
