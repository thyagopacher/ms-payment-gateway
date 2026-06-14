<?php

namespace App\Services;

use App\Enums\SendEmail;
use App\Repositories\EmailAttachmentRepository;
use App\Repositories\EmailRepository;
use Illuminate\Support\Facades\Log;
use SendGrid;
use SendGrid\Mail\Mail;

class EmailService
{

    private string $apiKey;

    public function __construct(
        private EmailRepository $emailRepository,
        private EmailAttachmentRepository $emailAttachmentRepository
    ) {
        $this->apiKey = config('services.sendgrid.api_key');
    }

    private function storeLogEmail(
        string $to,
        string $subject,
        string $body,
        string $from,
        bool $isHtml = false,
        array $attachments = [],
        string $status = SendEmail::PENDING->value
    ): int {

        $dataSending = [
            'to' => $to,
            'subject' => $subject,
            'body' => $body,
            'from' => $from,
            'isHtml' => $isHtml,
            'attachments' => $attachments,
            'status' => $status
        ];

        Log::info("Sending email to: ", $dataSending);

        $email = $this->emailRepository->create($dataSending);

        if (!empty($email->id)) {
            Log::info("Email log created with ID: " . $email->id);

            $this->storeEmailAttachments($email->id, $attachments);
        }

        return $email->id;
    }

    private function storeEmailAttachments(int $emailId, array $attachments): bool
    {
        if (empty($attachments)) {
            Log::info("No attachments to store for email ID: " . $emailId);
            return true;
        }

        foreach ($attachments as $attachment) {
            Log::info("Storing attachment for email ID: " . $emailId, $attachment);

            $this->emailAttachmentRepository->create([
                'email_id' => $emailId,
                'file_name' => $attachment['file_name'],
                'file_path' => $attachment['file_path'],
                'file_type' => $attachment['file_type'],
            ]);
        }

        return true;
    }


    private function storeLogEmailResponse(
        int $emailId,
        string $to,
        string $subject,
        string $body,
        string $from,
        bool $isHtml = false,
        array $attachments = [],
        string $status = SendEmail::FINISHED->value
    ): bool {

        $dataSending = [
            'to' => $to,
            'subject' => $subject,
            'body' => $body,
            'from' => $from,
            'isHtml' => $isHtml,
            'attachments' => $attachments,
            'status' => $status
        ];

        Log::info("Response to Send email to: ", $dataSending);

        $email = $this->emailRepository->update($emailId, $dataSending);

        return !empty($email->id);
    }

    public function sendEmail (
        string $to,
        string $subject,
        string $body,
        string $from,
        bool $isHtml = false,
        array $attachments = []
    ): bool {

        $emailId = $this->storeLogEmail($to, $subject, $body, $from, $isHtml, $attachments);

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
        $successSend = $response->statusCode() === 202;
        $successText = $successSend ? SendEmail::FINISHED->value : SendEmail::FAILED->value;
        $this->storeLogEmailResponse($emailId, $to, $subject, $body, $from, $isHtml, $attachments, $successText);

        return $response->statusCode() >= 200 && $response->statusCode() < 300;
    }
}
