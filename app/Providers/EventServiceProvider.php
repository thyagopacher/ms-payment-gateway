<?php

namespace App\Providers;

use App\Events\PaymentApproved;
use App\Listeners\PublishPaymentApproved;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        PaymentApproved::class => [
            PublishPaymentApproved::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
