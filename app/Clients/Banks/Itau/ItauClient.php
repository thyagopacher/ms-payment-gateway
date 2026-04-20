<?php

namespace App\Clients\Banks\Itau;

use App\Clients\BaseAuthApiClient;
use Illuminate\Support\Facades\Cache;

class ItauClient extends BaseAuthApiClient
{

    public function __construct()
    {
        // configuração do cliente para Banco do Brasil
        $this->apiUrl = config('services.boleto.itau.endpoint');
        $this->clientId = config('services.boleto.itau.api_key');
        $this->clientSecret = config('services.boleto.itau.api_secret');

        $this->headersAuth['x-itau-apikey'] = $this->clientId;

        parent::__construct();
    }

    public function getToken(): string
    {
        if (!$this->token) {
            $this->auth();
        }

        return $this->token;
    }

    /**
     * auth function
     *
     * @return array
     * @author Thyago Henrique Pacher <thyago.pacher@gmail.com.br>
     */
    public function auth(): array
    {
        $this->token = Cache::get('token_itau') ?? '';
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

        Cache::put('token_itau', $this->token, $this->expiresIn);

        return [
            'access_token' => $body['access_token'],
            'token_type' => $body['token_type'] ?? '',
            'expires_in' => $body['expires_in'],
            'active' => $body['active'] ?? '',
            'scope' => $body['scope'] ?? '',
        ];
    }

}
