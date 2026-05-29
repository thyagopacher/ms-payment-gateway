<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\Payment\BankSlipController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\PixController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\StateController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [AuthController::class, 'auth']);

Route::get('/health-check', [HealthCheckController::class, 'getStatus']);

Route::middleware(['throttle:60,1', JwtMiddleware::class])->group(function () {

    Route::prefix('bank-slip')->group(function () {
        Route::post('/create', [BankSlipController::class, 'generateBillingDocument']);
        Route::get('/print/{boletoId}', [BankSlipController::class, 'printBillingDocument']);
    });

    Route::resource('person', PersonController::class);

    Route::prefix('pix')->group(function () {
        Route::post('/qrcode', [PixController::class, 'create']);
    });

    Route::resource('payment', PaymentController::class);
    
    Route::resource('city', CityController::class);

    Route::resource('state', StateController::class);

});
