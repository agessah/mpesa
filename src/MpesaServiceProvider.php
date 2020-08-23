`<?php

namespace Agessah\Mpesa;

use Illuminate\Support\ServiceProvider;

class MpesaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'mpesa');

        $this->app->singleton(Mpesa::class, function () {
            return new Mpesa();
        });
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (function_exists('config_path')) :
            
            $this->publishes([
                __DIR__.'/config/config.php' => config_path('mpesa.php'),
            ], 'config');
        
        endif;
    }
}
