<?php

namespace App\Http\Controllers;

use App\Clients\Banks\BancoDoBrasil\BancoDoBrasilClient;
use App\Clients\Banks\Bradesco\BradescoClient;
use App\Clients\Banks\Itau\ItauClient;
use App\Clients\Banks\Santander\SantanderClient;
use App\Factories\BankFactory;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;
use Throwable;

class HealthCheckController extends Controller
{

    public function __construct(

    ) {

    }

    public function getStatus()
    {
        $res = [
            'status' => 'healthy',
            'timestamp' => now()->toDateTimeString(),
            'services' => [
                'database' => app()->make('db')->connection()->getPdo() ? 'connected' : 'disconnected',
                'redis' => app()->make('redis')->ping()
            ],
            'integrations' => [
                'banks' => [
                    'santander' => BankFactory::make('santander')->getStatusConnectionApi(),
                    'bradesco' => BankFactory::make('bradesco')->getStatusConnectionApi(),
                    'itau' => BankFactory::make('itau')->getStatusConnectionApi(),
                    'banco_do_brasil' => BankFactory::make('bb')->getStatusConnectionApi(),
                ]
            ]

        ];

        return response()->json($res);
    }

}
