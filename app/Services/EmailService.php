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
        array $from,
        bool $isHtml = false,
        array $attachments = [],
        string $status = SendEmail::PENDING->value
    ): int {

        $dataSending = [
            'to' => $to,
            'subject' => $subject,
            'body' => $body,
            'from' => json_encode($from),
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

    /**
     * storeEmailAttachments function
     *
     * @param integer $emailId
     * @param array $attachments - rows of $attachment [file_name, file_path, file_type]
     * @return boolean
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
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
        int $statusCode,
        string $responseBody,
        string $successText = SendEmail::FINISHED->value,
    ): bool {

        $dataSending = [
            'statusCode' => $statusCode,
            'responseBody' => $responseBody,
            'successText' => $successText
        ];

        Log::info("Response to Send email to: ", $dataSending);

        $email = $this->emailRepository->update($emailId, [
            'status' => $successText,
        ]);

        return !empty($email->id);
    }

    private function addAttachments(Mail $email, array $attachments): bool
    {
        Log::info("Adding attachments to email: ");

        if (empty($attachments)) {
            Log::info("No attachments to add.");
            return false;
        }

        foreach ($attachments as $attachment) {
            Log::info("Adding attachment: ", $attachment);
            $email->addAttachment(
                file_get_contents($attachment['file_path']),
                $attachment['file_type'],
                $attachment['file_name']
            );
        }

        return true;
    }

    /**
     * sendEmail function
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param array $from - [from_email, from_name]
     * @param boolean $isHtml
     * @param array $attachments
     *
     * @return boolean
     *
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function sendEmail (
        string $to,
        string $subject,
        string $body,
        array $from = [],
        bool $isHtml = false,
        array $attachments = []
    ): bool {

        Log::info("Preparing to send email to: " . $to);

        if (empty($from)) {
            $from['from_email'] = config('services.sendgrid.from_email');
            $from['from_name'] = config('services.sendgrid.from_name');
        }
        $emailId = $this->storeLogEmail($to, $subject, $body, $from, $isHtml, $attachments);

        $email = new Mail();

        $email->setFrom(
            $from['from_email'],
            $from['from_name']
        );

        $email->setSubject($subject);
        $email->addTo($to);

        $formatContent = $isHtml ? 'text/html' : 'text/plain';
        $email->addContent($formatContent, $body);

        $this->addAttachments($email, $attachments);

        $sendGrid = new SendGrid($this->apiKey);

        $response = $sendGrid->send($email);
        $successSend = $response->statusCode() === 202;
        $successText = $successSend ? SendEmail::FINISHED->value : SendEmail::FAILED->value;
        $this->storeLogEmailResponse($emailId, $response->statusCode(), $response->body(), $successText);

        Log::info("Response to send email to: " . $to, [
            'statusCode' => $response->statusCode(),
            'responseBody' => $response->body(),
            'success' => $successSend
        ]);

        return $successSend;
    }
}
