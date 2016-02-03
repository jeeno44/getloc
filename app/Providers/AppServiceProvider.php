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
        });
        \Event::listen('site.done', function($site) {
            \Mail::send('emails.site-done', compact('site'), function($m) use ($site) {
                $m->to($site->user->email)->subject('Мы проанализировали ваш проект "'.$site->url.'"');
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
