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

}
