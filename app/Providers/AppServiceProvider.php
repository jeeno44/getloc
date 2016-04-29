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
            $subscription = \App\Subscription::where('site_id', $site)->first();
            if ($subscription) {
                \Event::fire('blocks.changed', $subscription);
            }
        });
        \Event::listen('site.start', function($site){
            $domain = env('APP_DOMAIN');
            \Redis::publish('spider', json_encode(['site' => $site->id, 'api' => 'api.'.$domain], JSON_UNESCAPED_UNICODE));
        });
        \Event::listen('order.payed', function ($order) {
            $translates = \DB::table('translates')
                ->join('blocks', 'blocks.id', '=', 'translates.block_id')
                ->join('languages', 'languages.id', '=', 'translates.language_id')
                ->whereIn('translates.id', $order->translates()->lists('id')->toArray())
                ->select('blocks.text', 'languages.id', 'languages.short')
                ->get();
            $site = $order->site;
            $lang = !empty($site->language->short) ? $site->language->short : 'undefined';
            $ts = [];
            foreach ($translates as $t) {
                $ts[] = [
                    'from'      => $lang,
                    'to'        => $t->short,
                    'from_id'   => $site->language_id,
                    'to_id'     => $t->id,
                    'text'      => $t->text,
                ];
            }
            $xml = array_to_xml($ts, new \SimpleXMLElement('<root/>'))->asXML();
            $xml = html_entity_decode($xml, ENT_NOQUOTES, 'UTF-8');
            if (!file_exists(public_path('uploads'))) {
                \File::makeDirectory(public_path('uploads'), 0777, false, false);
            }
            \File::put(public_path('uploads/order_'.$order->id.'.xml'), $xml);
        });
        \Event::listen('blocks.changed', function ($subscription) {
            rebuildAvailableBlocks($subscription);
        });
        \Event::listen('site.blocks-changed', function ($site) {
            $subscription = \App\Subscription::where('site_id', $site->id)->first();
            if ($subscription) {
                rebuildAvailableBlocks($subscription);
            }
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
