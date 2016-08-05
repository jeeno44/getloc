<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Scan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                if ( !($request->route()->getAction()['as'] == 'scan.login.form' ||
                    $request->route()->getAction()['as'] == 'scan.register.form'))
                    return redirect()->guest('login');
            }
        }
        
        return $next($request);
    }
}