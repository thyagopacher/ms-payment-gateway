<?php

namespace App\Services;

use App\Services\KafkaService;
use App\Enums\PaymentStatus;
use App\Exceptions\NotFoundException;
use App\Notifications\InvoicePaid;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\Log;

class PaymentService
{

    public function __construct(
        private PaymentRepository $paymentRepository,
        private KafkaService $kafkaService
    ) {

    }

    public function createPayment(array $paymentData)
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
            'message' => 'Pagamento criado com sucesso!',
            'data'    => $payment->only(['id', 'amount', 'status', 'payment_method'])
        ];
    }

    public function approvePayment(int $paymentId): bool
    {
        $payment = $this->paymentRepository->find($paymentId);
        if (!$payment) {
            throw new NotFoundException('Pagamento não encontrado.');
        }

        if ($payment->status->isPaid()) {
            Log::info("Pagamento ID {$payment->id} já estava aprovado.");
            return true;  // Já está pago
        }

        $payment->status = PaymentStatus::PAID;
        $payment->save();

        Log::info("Pagamento ID aprovado.", [
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'person_id' => $payment->person_id
        ]);

        $this->kafkaService->publish('payment-approved', [
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'person_id' => $payment->person_id,
            'status' => $payment->status,
        ]);

        Log::info("Mensagem de pagamento aprovado publicada no Kafka para pagamento ID {$payment->id}.");

        return true;
    }

    public function getPayments(array $filters = []): array
    {
        return $this->paymentRepository->getPayments($filters);
    }

}
