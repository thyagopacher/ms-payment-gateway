<?php

namespace App\Listeners;

use App\Services\KafkaService;
use Illuminate\Contracts\Queue\ShouldQueue;

class PublishPaymentApproved implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private KafkaService $kafkaService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $payment = $event->payment;

        $this->kafkaService->publish('payment-approved', [
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'person_id' => $payment->person_id,
            'status' => $payment->status,
        ]);
    }
}
