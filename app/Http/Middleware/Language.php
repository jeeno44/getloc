<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class Language
{
    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->segment(1);
        
        if (array_key_exists($locale, $this->app->config->get('app.locales'))) {
            $this->app->setLocale($locale);
            \Session::set('locale', $locale);  
        } else {
            if ( !\Session::has('locale') )
                $this->app->setLocale($this->app->config->get('app.fallback_locale'));
        }
        
        if ( $this->request->ajax() )
          {
            if ( \Session::has('locale') )
              {
                $this->app->setLocale(\Session::get('locale'));
              }
          }
        
        return $next($request);
    }
}
