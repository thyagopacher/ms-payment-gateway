<?php

namespace App\Clients\Banks\BancoDoBrasil;

use App\Clients\BaseAuthApiClient;
use Illuminate\Support\Facades\Cache;

class BancoDoBrasilClient extends BaseAuthApiClient
{

    public function __construct()
    {
        $this->apiUrl = config('services.boleto.banco_do_brasil.endpoint');
        $this->clientId = config('services.boleto.banco_do_brasil.api_key');
        $this->clientSecret = config('services.boleto.banco_do_brasil.api_secret');

        parent::__construct();
    }

    public function getToken(): string
    {
        if (!$this->token) {
            $this->auth();
        }

        return $this->token;
    }

    public function auth(): array
    {
        $this->token = Cache::get('token_bradesco') ?? '';
        if (!empty($this->token)) {
            return [
                'access_token' => $this->token,
                'token_type' => '',
                'expires_in' => $this->expiresIn,
                'active' => '',
                'scope' => '',
            ];
        }

        $body = parent::authenticate('/api/oauth/jwt');

        $this->token = $body['access_token'];
        $this->expiresIn = $body['expires_in'];

        Cache::put('token_bradesco', $this->token, $this->expiresIn);

        return [
            'access_token' => $body['access_token'],
            'token_type' => $body['token_type'] ?? '',
            'expires_in' => $body['expires_in'],
            'active' => $body['active'] ?? '',
            'scope' => $body['scope'] ?? '',
        ];
    }

}
