<?php

namespace App\Console\Commands;

use App\Jobs\SendPaymentApprovedEmailJob;
use App\Services\KafkaService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

#[Signature('kafka:consume-payments')]
#[Description('Kafka consumer para processar mensagens de pagamento aprovado')]
class KafkaConsumePayment extends Command
{

    protected $signature = 'kafka:consume-payments';

    /**
     * Execute the console command.
     */
    public function handle(KafkaService $kafkaService): void
    {
        $kafkaService->startConsumer('payment-approved', function ($message) {
            $payload = $message->getBody();
            Log::info('Received Kafka message:', $payload);

            // Dispatch a job to send the email notification
            SendPaymentApprovedEmailJob::dispatch($payload['email'], $payload);
        });
    }
}
