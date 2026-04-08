<?php

namespace App\Clients\Banks\Santander;

use App\Clients\BaseAuthApiClient;
use Illuminate\Support\Facades\Cache;

class SantanderClient extends BaseAuthApiClient
{

    protected string $apiUrl = '';
    protected string $clientId = '';
    protected string $clientSecret = '';
    protected string $token = '';
    protected int $expiresIn = 0;

    public function __construct()
    {
        // configuração do cliente para Banco do Brasil
        $this->apiUrl = config('services.boleto.santander.endpoint');
        $this->clientId = config('services.boleto.santander.api_key');
        $this->clientSecret = config('services.boleto.santander.client_secret');

        parent::__construct($this->apiUrl, $this->clientId, $this->clientSecret);
    }

    public function auth(): array
    {
        $this->token = Cache::get('token_santander');
        if (!empty($this->token)) {
            return [
                'access_token' => $this->token,
                'token_type' => '',
                'expires_in' => $this->expiresIn,
                'active' => '',
                'scope' => '',
            ];
        }

        $body = parent::authenticate('/auth/oauth/v2/token');

        $this->token = $body['access_token'];
        $this->expiresIn = $body['expires_in'];

        Cache::put('token_santander', $this->token, $this->expiresIn);

        return [
            'access_token' => $body['access_token'],
            'token_type' => $body['token_type'] ?? '',
            'expires_in' => $body['expires_in'],
            'active' => $body['active'] ?? '',
            'scope' => $body['scope'] ?? '',
        ];
    }

}
