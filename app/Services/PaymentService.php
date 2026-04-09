<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Notifications\InvoicePaid;

class PaymentService
{

    public function processPayment($paymentData)
    {
        // Validação básica (pode ser feita antes com Form Request)
        if (empty($paymentData['amount']) || empty($paymentData['person_id'])) {
            throw new \InvalidArgumentException('Dados obrigatórios ausentes.');
        }

        $payment = Payment::create([
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
        $query = Payment::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['person_id'])) {
            $query->where('person_id', $filters['person_id']);
        }

        return $query->get()->toArray();
    }

}
