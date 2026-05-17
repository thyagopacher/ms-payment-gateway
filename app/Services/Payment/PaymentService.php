<?php

namespace App\Services\Payment;

use App\Dto\PaymentoDTO;
use App\Enums\PaymentStatus;
use App\Events\PaymentApproved;
use App\Exceptions\NotFoundException;
use App\Factories\PaymentMethodFactory;
use App\Models\Payment;
use App\Models\Person;
use App\Notifications\InvoicePaid;
use App\Repositories\PaymentRepository;
use App\Repositories\PersonRepository;
use Illuminate\Support\Facades\Log;

class PaymentService
{

    public function __construct(
        private PaymentRepository $paymentRepository,
        private PersonRepository $personRepository,
    ) {

    }

    public function createPayment(PaymentoDTO $paymentDto): array
    {

        /**
         * @var Person $person
         */
        $person = $this->personRepository->findByDocument($paymentDto->document);
        if (empty($person->id)) {
            throw new NotFoundException(__('api.select_not_found'));
        }

        /**
         * @var Payment $payment
         */
        $payment = $this->paymentRepository->create([
            'amount'         => $paymentDto->amount->getValue(),
            'payment_method' => $paymentDto->payment_method ?? 'credit_card',
            'status'         => PaymentStatus::PENDING->value,
            'due_date'       => $paymentDto->dueDate,
            'paid_at'        => $paymentDto->paidAt,
            'person_id'      => $person->id ?? 0,
        ]);

        //identifica qual a service relacionada ao método de pgto e efetiva o pgto no banco
        $paymentMethodService = PaymentMethodFactory::make($paymentDto->payment_method->value);
        $paymentRegistered = $paymentMethodService->create($paymentDto->toArray());

        // Dispara a notificação
        $payment->notify(new InvoicePaid($payment));

        return $paymentRegistered;
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
