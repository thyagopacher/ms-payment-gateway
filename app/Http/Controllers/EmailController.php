<?php

namespace App\Http\Controllers;

use App\Services\EmailService;
use App\Http\Requests\EmailRequest;
use OpenApi\Attributes as OA;

class EmailController extends Controller
{

    public function __construct(private EmailService $emailService)
    {

    }

    #[OA\Post(
        path: "/api/email/create",
        summary: "Create to email",
        tags: ['Email'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Create Email'
            ),
            new OA\Response(
                response: 422,
                description: 'Error in creat Email'
            )
        ]
    )]
    public function create(EmailRequest $request)
    {
        $params = $request->validated();
        return $this->emailService->create($params);
    }

    #[OA\Post(
        path: "/api/email/send",
        summary: "Send to email",
        tags: ['Email'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Send Email'
            ),
            new OA\Response(
                response: 404,
                description: 'Error in send Email'
            )
        ]
    )]
    public function send(EmailRequest $request)
    {
        $params = $request->validated();
        return $this->emailService->sendEmail(
            $params['to'],
            $params['subject'],
            $params['body'],
            $params['from'],
            $params['isHtml'],
            $params['attachments']
        );
    }

    #[OA\Get(
        path: "/api/email/open/{id}",
        summary: "Mark email opened",
        tags: ['Email'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Email is marked'
            ),
            new OA\Response(
                response: 404,
                description: 'Email is Not Found'
            )
        ]
    )]
    public function markAsOpened(string $emailIdHashed)
    {
        $idEmail = base64_decode($emailIdHashed);
        $email = $this->emailService->update($idEmail, [
            'read_at' => now()
        ]);

        return response()->file(
            storage_path('app/public/pixel.png')
        );
    }
}
