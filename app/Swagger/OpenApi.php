<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0',
    title: 'Gateway de Pagamentos API',
    description: 'Documentação da API',
    contact: new OA\Contact(name: 'Swagger API Team'),
)]
class OpenApi
{

    #[OA\Get(
        path: "/api/health-check",
        summary: "Health check",
        responses: [
            new OA\Response(
                response: 200,
                description: 'Service is healthy'
            )
        ]
    )]
    public function healthCheck()
    {
    }
}
