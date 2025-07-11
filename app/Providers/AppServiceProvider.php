<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
    public function boot()
    {

        // // 🔥 NGROK支援
        // if (request()->header('x-forwarded-proto') === 'https') {
        //     URL::forceScheme('https');
        // }

        // // 🔥 檢查是否為NGROK環境
        // if (request()->server('HTTP_HOST') && strpos(request()->server('HTTP_HOST'), 'ngrok') !== false) {
        //     $this->app['request']->server->set('HTTPS', true);
        // }
    }
}
