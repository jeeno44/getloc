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
            //\Queue::push(new \App\Jobs\TextsCollector($site));
            $domain = env('APP_DOMAIN');
            if ( \DB::table('site_tate_collector')->count() == 0 )
                \Redis::publish('collector', json_encode(['site' => $site->id, 'api' => 'api.'.$domain], JSON_UNESCAPED_UNICODE));
            
            \DB::table('site_tate_collector')->insert(['siteID' => $site->id]);
        });
        \Event::listen('site.done', function($site) {
            //\Queue::push(new \App\Jobs\CreateEmptyTranslates($site));
            \Mail::send('emails.site-done', compact('site'), function($m) use ($site) {
                $m->to($site->user->email)->subject('Мы проанализировали ваш проект "'.$site->url.'"');
            });
        });
        \Event::listen('site.start', function($site){
            $domain = env('APP_DOMAIN');
            \Redis::publish('spider', json_encode(['site' => $site->id, 'api' => 'api.'.$domain], JSON_UNESCAPED_UNICODE));
        });
        \Event::listen('order.payed', function ($order) {
            // TODO отсылать заказ переводчику
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
