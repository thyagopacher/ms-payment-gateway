<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use SendGrid;
use SendGrid\Mail\Mail;

class EmailService
{

    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.sendgrid.api_key');
    }

    public function sendEmail(string $to, string $subject, string $body, string $from, bool $isHtml = false, array $attachments = []): bool
    {
        Log::info("Sending email to: ", [
            'to' => $to,
            'subject' => $subject,
            'body' => $body,
            'from' => $from,
            'isHtml' => $isHtml,
            'attachments' => $attachments
        ]);

        $email = new Mail();

        $email->setFrom(
            config('services.sendgrid.from_email'),
            config('services.sendgrid.from_name')
        );

        $email->setSubject($subject);
        $email->addTo($to);

        $formatContent = $isHtml ? 'text/html' : 'text/plain';
        $email->addContent($formatContent, $body);

        $sendGrid = new SendGrid($this->apiKey);

        $response = $sendGrid->send($email);

        return $response->statusCode() >= 200 && $response->statusCode() < 300;
    }
}
