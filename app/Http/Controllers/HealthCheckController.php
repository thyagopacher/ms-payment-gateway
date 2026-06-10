<?php

namespace App\Http\Controllers;

use App\Factories\BankFactory;
use App\Services\KafkaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

class HealthCheckController extends Controller
{

    public function __construct(

    ) {

    }

    private function getStatusRedis(): bool
    {
        try {
            $res = app()->make('redis')->ping();
            return $res;
        } catch (\Exception $e) {
            Log::error('Redis health check failed: ' . $e->getMessage());
            return false;
        }
    }

    private function getStatusDatabase(): bool
    {
        try {
            DB::select('SELECT 1');

            return true;
        } catch (\Throwable $e) {
            Log::error('Database health check failed', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

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
    public function getStatus()
    {
        $res = [
            'status' => 'healthy',
            'timestamp' => now()->toDateTimeString(),
            'services' => [
                'database' => $this->getStatusDatabase(),
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
