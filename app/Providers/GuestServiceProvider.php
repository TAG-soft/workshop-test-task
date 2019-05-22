<?php

namespace App\Providers;

use App\Services\GuestService;
use Illuminate\Support\ServiceProvider;

class GuestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(GuestService::class, function ($app) {
            return new GuestService();
        });
    }
}
