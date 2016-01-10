<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Event::listen('maps.done', function($site) {
            \Queue::push(new \App\Jobs\TextsCollector($site));
            \Mail::send('emails.map', compact('site'), function($m) use ($site) {
                $m->to($site->user->email)->subject('Структура сайта обработана');
            });
        });
        \Event::listen('site.done', function($site) {
            \Mail::send('emails.done', compact('site'), function($m) use ($site) {
                $m->to($site->user->email)->subject('Обработка сайта завершена');
            });
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
