<?php

namespace Blackgremlin\Yandexkassa;

use Illuminate\Support\ServiceProvider;

class YandexKassaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }
        $this->loadViewsFrom(__DIR__.'/views', 'yakassa');
        $this->publishes([
            __DIR__.'/config/yakassa.php' => config_path('yakassa.php'),
        ]);
        require __DIR__.'/helpers.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
