<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return json_encode([
        'service' => config('app.name'),
        'description' => 'Payment Gateway API',
        'version' => config('app.version', '1.0.0'),
        'environment' => app()->environment(),
        'documentation' => url('/docs'),
        'status' => 'online',
        'timestamp' => now()->toISOString(),
    ]);
});
