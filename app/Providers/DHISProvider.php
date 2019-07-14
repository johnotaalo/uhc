<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DHISProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require app_path() . '/Helpers/DHISDataHelper.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
