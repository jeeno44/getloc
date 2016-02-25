<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        if (empty($user) || !$user->hasRole('admin')) {
            return redirect()->route('admin.login.form');
        }
        return $next($request);
    }
}
