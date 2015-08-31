<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AccessToken;
use App\Http\Requests\Request;
use Response;

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
        $message = [];
        $userId = $request->query('user_id');
        $token = $request->query('token');
        if (!$userId)
        {
            $message['error'][] = Request::ERROR_VALIDATE_USER_ID_REQUIRED;
        }
        if (!$token)
        {
            $message['error'][] = Request::ERROR_VALIDATE_ACCESS_TOKEN_REQUIRED;
        }

        if (!isset($message['error']))
        {
            if (!AccessToken::expired($userId, $token))
            {
                return $next($request);
            }
            else
            {
                $message['error'][] = Request::ERROR_VALIDATE_ACCESS_TOKEN_EXPIRED;
            }
        }
        return Response::json($message, 200);
    }
}
