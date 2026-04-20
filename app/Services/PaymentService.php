<?php

namespace App\Services;

use App\Services\KafkaService;
use App\Enums\PaymentStatus;
use App\Events\PaymentApproved;
use App\Exceptions\NotFoundException;
use App\Factories\PaymentMethodFactory;
use App\Models\Payment;
use App\Notifications\InvoicePaid;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\Log;

class PaymentService
{

    public function __construct(
        private PaymentRepository $paymentRepository
    ) {

    }

    public function createPayment(array $paymentData): Payment
    {

        $payment = $this->paymentRepository->create([
            'amount'         => $paymentData['amount'],
            'payment_method' => $paymentData['payment_method'] ?? 'credit_card',
            'status'         => PaymentStatus::PENDING->value,
            'person_id'      => $paymentData['person_id'],
        ]);

        // Dispara a notificação
        $payment->notify(new InvoicePaid($payment));

        return $payment;
    }

    public function approvePayment(int $paymentId): bool
    {
        $payment = $this->paymentRepository->find($paymentId);
        if (!$payment) {
            throw new NotFoundException(__('api.select_not_found'));
        }

        if ($payment->status->isPaid()) {
            Log::info("Pagamento ID {$payment->id} já estava aprovado.");
            return true;  // Já está pago
        }

        $this->paymentRepository->update($paymentId, [
            'status' => PaymentStatus::PAID->value
        ]);

        Log::info("Pagamento ID aprovado.", [
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'person_id' => $payment->person_id
        ]);

        event(new PaymentApproved($payment));

        Log::info("Mensagem de pagamento aprovado publicada no Kafka para pagamento ID {$payment->id}.");

        return true;
    }

    public function getPayments(array $filters = []): array
    {
        return $this->paymentRepository->getPayments($filters);
    }

}
