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
            \Queue::push(new \App\Jobs\CreateEmptyTranslates($site));
            \Mail::send('emails.site-done', compact('site'), function($m) use ($site) {
                $m->to($site->user->email)->subject('Мы проанализировали ваш проект "'.$site->url.'"');
            });
        });
        \Event::listen('site.start', function($site){
            $domain = env('APP_DOMAIN');
            \Redis::publish('spider', json_encode(['site' => $site->id, 'api' => 'api.'.$domain], JSON_UNESCAPED_UNICODE));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register(\Laracasts\Generators\GeneratorsServiceProvider::class);
        }
    }
}
