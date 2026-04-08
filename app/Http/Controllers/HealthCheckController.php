<?php

namespace App\Http\Controllers;



class HealthCheckController extends Controller
{

    public function getStatus()
    {

        $res = [
            'status' => 'healthy',
            'timestamp' => now()->toDateTimeString(),
            'services' => [
                'database' => app()->make('db')->connection()->getPdo() ? 'connected' : 'disconnected',
                'redis' => app()->make('redis')->ping()
            ]
        ];

        return response()->json($res);
    }

}
