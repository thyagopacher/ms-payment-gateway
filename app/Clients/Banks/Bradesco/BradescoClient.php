<?php

namespace App\Clients\Banks\Bradesco;

use App\Clients\BaseAuthApiClient;
use Illuminate\Support\Facades\Cache;

class BradescoClient extends BaseAuthApiClient
{

    public function __construct()
    {
        $this->apiUrl = config('services.boleto.bradesco.endpoint');
        $this->clientId = config('services.boleto.bradesco.api_key');
        $this->clientSecret = config('services.boleto.bradesco.api_secret');

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

        $certs = [
            'ssl_key' => [storage_path('certs/certificado.pem'), env('SENHA_CERTIFICADO')],
        ];
        $body = parent::authenticate('/api/oauth/jwt', $certs);

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
