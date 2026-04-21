<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankSlipController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PixController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [AuthController::class, 'auth']);

Route::get('/health-check', [HealthCheckController::class, 'getStatus']);

Route::prefix('payments')->middleware([JwtMiddleware::class])->group(function () {
    Route::get('/', [PaymentController::class, 'getPayments']);
});

Route::prefix('bank-slip')->middleware(['throttle:60,1', JwtMiddleware::class])->group(function () {
    Route::post('/create', [BankSlipController::class, 'generateBillingDocument']);
    Route::get('/print/{boletoId}', [BankSlipController::class, 'printBillingDocument']);
});

Route::prefix('pix')->middleware([JwtMiddleware::class])->group(function () {
    Route::post('/qrcode', [PixController::class, 'create']);
});

Route::prefix('person')->middleware([JwtMiddleware::class])->group(function () {
    Route::post('/', [PersonController::class, 'create']);
    Route::put('/update', [PersonController::class, 'update']);
    Route::delete('/delete', [PersonController::class, 'delete']);
    Route::get('/find', [PersonController::class, 'find']);
});
