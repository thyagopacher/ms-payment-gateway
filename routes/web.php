<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return json_encode([
        'name' => config('app.name'),
        'version' => '1.0.0',
        'status' => 'running'
    ]);
});
