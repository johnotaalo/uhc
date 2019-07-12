<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Log;

use DB;
use Event;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        Schema::defaultStringLength(191);
        if (env('APP_ENV') !== 'local') {
            $url->forceScheme('https');
        }

        if (env('APP_ENV') === 'local') {
            // DB::connection()->enableQueryLog();
            // Event::listen('kernel.handled', function ($request, $response) {
            //     if ( $request->has('sql-debug') ) {
            //         $queries = DB::getQueryLog();
            //         dd($queries);
            //     }
            // });
        }
    }
}
