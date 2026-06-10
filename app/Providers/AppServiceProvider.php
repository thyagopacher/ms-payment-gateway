<?php

namespace App\Providers;

use App\Contracts\PdfAdapterInterface;
use App\Services\Pdf\MpdfAdapter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PdfAdapterInterface::class,
            MpdfAdapter::class,
        );

        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
