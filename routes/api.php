<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\Payment\BankSlipController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\PixController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\StateController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [AuthController::class, 'auth']);

Route::get('/health-check', [HealthCheckController::class, 'getStatus']);

// Stripe routes (for testing purposes - accessible without JWT)
Route::prefix('stripe')->group(function () {
    Route::post(
        '/charges/create',
        [StripeController::class, 'createCharge']
    );

    Route::get(
        '/charges/{chargeId}/get',
        [StripeController::class, 'getCharge']
    );

    Route::get(
        '/charges/{limit}/list',
        [StripeController::class, 'listCharges']
    );

    Route::post(
        '/charges/{chargeId}/capture',
        [StripeController::class, 'captureCharge']
    );

    Route::put(
        '/charges/{chargeId}',
        [StripeController::class, 'updateCharge']
    );

    Route::post(
        '/refund/{chargeId}',
        [StripeController::class, 'refundCharge']
    );

    Route::post(
        '/refund/{chargeId}/{amount}',
        [StripeController::class, 'partialRefundCharge']
    );

    Route::get(
        '/refunds/{refundId}',
        [StripeController::class, 'getRefund']
    );
});

Route::middleware(['throttle:60,1', JwtMiddleware::class])->group(function () {

    Route::prefix('bank-slip')->group(function () {
        Route::post('/create', [BankSlipController::class, 'generateBillingDocument']);
        Route::get('/print/{boletoId}', [BankSlipController::class, 'printBillingDocument']);
    });

    Route::prefix('pix')->group(function () {
        Route::post('/', [PixController::class, 'create']);
    });

    Route::resource('person', PersonController::class);

    Route::resource('payment', PaymentController::class);

    Route::get('/payments/report/pdf', [PaymentController::class, 'pdfReport']);
    Route::get('/payments/report/csv', [PaymentController::class, 'csvReport']);

    Route::resource('city', CityController::class);

    Route::resource('state', StateController::class);
});
