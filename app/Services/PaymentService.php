<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Notifications\InvoicePaid;
use App\Repositories\PaymentRepository;

class PaymentService
{

    public function __construct(private PaymentRepository $paymentRepository)
    {

    }

    public function processPayment($paymentData)
    {
        // Validação básica (pode ser feita antes com Form Request)
        if (empty($paymentData['amount']) || empty($paymentData['person_id'])) {
            throw new \InvalidArgumentException('Dados obrigatórios ausentes.');
        }

        $payment = $this->paymentRepository->create([
            'amount'         => $paymentData['amount'],
            'payment_method' => $paymentData['payment_method'] ?? 'credit_card',
            'status'         => PaymentStatus::PENDING->value,
            'person_id'      => $paymentData['person_id'],
        ]);

        // Dispara a notificação
        $payment->notify(new InvoicePaid($payment));

        return [
            'status'  => 'success',
            'message' => 'Pagamento processado com sucesso!',
            'data'    => $payment->only(['id', 'amount', 'status', 'payment_method'])
        ];
    }

    public function getPayments(array $filters = []): array
    {
        return $this->paymentRepository->getPayments($filters);
    }

}
