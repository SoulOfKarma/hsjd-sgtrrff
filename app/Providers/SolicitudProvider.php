<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class SolicitudProvider extends ServiceProvider
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
        //
        //\App\SolicitudTickets::observe(\App\Observers\SolicitudObserver::class);
    }
}
