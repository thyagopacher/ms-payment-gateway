<?php

namespace App\Clients\Banks\Itau;

use App\Clients\BaseAuthApiClient;

class BradescoClient extends BaseAuthApiClient
{

    protected string $apiUrl = '';
    protected string $clientId = '';
    protected string $clientSecret = '';
    protected string $token = '';
    protected int $expiresIn = 0;

    public function __construct()
    {
        $this->apiUrl = config('services.boleto.bradesco.endpoint');
        $this->clientId = config('services.boleto.bradesco.api_key');
        $this->clientSecret = config('services.boleto.bradesco.client_secret');

        parent::__construct($this->apiUrl, $this->clientId, $this->clientSecret);
    }

    public function auth(): array
    {
        $body = parent::authenticate('/api/oauth/jwt');

        $this->token = $body['access_token'];
        $this->expiresIn = $body['expires_in'];

        return [
            'access_token' => $body['access_token'],
            'token_type' => $body['token_type'] ?? '',
            'expires_in' => $body['expires_in'],
            'active' => $body['active'] ?? '',
            'scope' => $body['scope'] ?? '',
        ];
    }

}
