<?php

namespace App\Jobs;

use App\Mail\PaymentApprovedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendPaymentApprovedEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $email, private array $payment)
    {
        //
    }

    public function handle(): void
    {
        Mail::to($this->email)
            ->send(new PaymentApprovedMail($this->email, $this->payment));
    }
}
