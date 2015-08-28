<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AuthenticateOnceWithBasicAuth
{
    /**
     * 
     * @param \Illuminate\Http\Request $request 
     * @param \Closure $next 
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return Auth::onceBasic('username', $request) ?: $next($request);
    }

}
