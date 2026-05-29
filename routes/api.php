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

    Route::prefix('payments')->group(function () {
        Route::get('/', [PaymentController::class, 'getPayments']);
        Route::post('/', [PaymentController::class, 'createPayment']);
    });

    Route::prefix('bank-slip')->group(function () {
        Route::post('/create', [BankSlipController::class, 'generateBillingDocument']);
        Route::get('/print/{boletoId}', [BankSlipController::class, 'printBillingDocument']);
    });

    Route::resource('person', PersonController::class);

    Route::prefix('pix')->group(function () {
        Route::post('/qrcode', [PixController::class, 'create']);
    });

    Route::resource('city', CityController::class);

    Route::resource('state', StateController::class);

});
