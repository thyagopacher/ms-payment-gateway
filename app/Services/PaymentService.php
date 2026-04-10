<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Jobs\SendPaymentApprovedEmailJob;
use App\Notifications\InvoicePaid;
use App\Repositories\PaymentRepository;
use Junges\Kafka\Facades\Kafka;

class PaymentService
{

    public function __construct(private PaymentRepository $paymentRepository)
    {

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

    public function paidPayment(int $paymentId)
    {
        $payment = $this->paymentRepository->find($paymentId);
        if (!$payment) {
            throw new \Exception('Pagamento não encontrado.');
        }

        $payment->status = PaymentStatus::PAID->value;
        $payment->save();

        // Dispara a notificação
        SendPaymentApprovedEmailJob::dispatch(
            $payment->person()->email,
            $payment->toArray()
        );
        $kafkaService = new KafkaService();
        $kafkaService->publish('payment-approved', [
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'person_id' => $payment->person_id,
            'status' => $payment->status,
        ]);

        return [
            'status'  => 'success',
            'message' => 'Pagamento aprovado com sucesso!',
            'data'    => $payment->only(['id', 'amount', 'status', 'payment_method'])
        ];
    }

    public function getPayments(array $filters = []): array
    {
        return $this->paymentRepository->getPayments($filters);
    }

}
