<?php

namespace App\Http\Controllers;

use App\Factories\BankFactory;
use App\Services\KafkaService;

class HealthCheckController extends Controller
{

    public function __construct(

    ) {

    }

    private function getStatusRedis(): bool
    {
        try {
            return app()->make('redis')->ping() === 'PONG';
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getStatus()
    {
        $res = [
            'status' => 'healthy',
            'timestamp' => now()->toDateTimeString(),
            'services' => [
                'database' => app()->make('db')->connection()->getPdo() ? 'connected' : 'disconnected',
                'redis' => $this->getStatusRedis(),
                'kafka' => (new KafkaService())->healthCheck() ? 'connected' : 'disconnected',
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
