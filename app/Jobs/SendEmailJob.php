<?php

namespace App\Jobs;

use App\Services\EmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private array $to,
        private string $subject,
        private string $body,
        private array $attachments = []
    ) {
        Log::info("Job created to send email to: " . implode(', ', $to), [
            'subject' => $subject,
            'body' => $body
        ]);
    }

    public function handle(EmailService $emailService): void
    {
        Log::info("Enviando email por JOB para: " . implode(', ', $this->to), [
            'subject' => $this->subject,
            'body' => $this->body,
            'to' => json_encode($this->to)
        ]);
        $successSend = $emailService->sendEmail(
            $this->to['to_email'],
            $this->subject,
            $this->body,
            $this->attachments
        );

        if (!$successSend) {
            Log::error("Failed to send email to: " . implode(', ', $this->to));
            return;
        }

        Log::info("Email sent successfully to: " . implode(', ', $this->to));
    }
}
