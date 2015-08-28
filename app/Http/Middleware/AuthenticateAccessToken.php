<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AccessToken;

class AuthenticateAccessToken
{
    /**
     * 
     * @param \Illuminate\Http\Request $request 
     * @param \Closure $next 
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (
            ($userId = $request->query('user_id'))
            && ($token = $request->query('token'))
            && !AccessToken::expired($userId, $token)
        )
        {
            return $next($request);
        }
        return response('Unauthorized.', 401);
    }
}
