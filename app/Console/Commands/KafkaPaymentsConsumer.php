<?php

namespace App\Console\Commands;

use App\Jobs\SendPaymentApprovedEmailJob;
use App\Services\KafkaService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

#[Signature('kafka:payments-consumer')]
#[Description('Kafka consumer para processar mensagens de pagamento aprovado')]
class KafkaPaymentsConsumer extends Command
{

    /**
     * Execute the console command.
     */
    public function handle(KafkaService $kafkaService): void
    {
        $kafkaService->startConsumer('payment-approved', function ($message) {
            $payload = $message->getBody();
            
            Log::info('Payment approved message received', [
                'payment_id' => $payload['payment_id'] ?? null,
                'email' => $payload['email'] ?? null,
                'amount' => $payload['amount'] ?? null,
                'timestamp' => now()
            ]);

            // Dispatch a job to send the email notification
            SendPaymentApprovedEmailJob::dispatch($payload['email'], $payload);
        });
    }
}
