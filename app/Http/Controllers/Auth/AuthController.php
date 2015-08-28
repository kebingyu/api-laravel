<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\AccessToken;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function register(RegisterRequest $request)
    {
        $message = [];
        if ($user = User::createUser($request->input()))
        {
            $message = [
                'user_created' => [
                    'username'   => $user->username,
                    'created at' => $user->created_at,
                ]
            ];
        }
        return json_encode($message);
    }

    public function login(LoginRequest $request)
    {
        $message = [];
        if (
            ($userId = User::validate($request->input()))
            && ($token = AccessToken::createToken($userId))
        )
        {
            $message = [
                'user_loggedin' => [
                    'user_id' => $userId,
                    'token'   => $token,
                ],
            ];
        }
        return json_encode($message);
    }

    public function logout(LogoutRequest $request)
    {
        $message = [];
        if ($loggedout = AccessToken::logout($request->input()))
        {
            $message = [
                'user_loggedout' => $loggedout,
            ];
        }
        return json_encode($message);
    }
}
