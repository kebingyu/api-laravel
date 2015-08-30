<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\AccessToken;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Requests\Request;
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
        if ($user = User::createUser($request->input()))
        {
            $message = $this->getMessage('success',
                [
                    'username'   => $user->username,
                    'created at' => $user->created_at,
                ]
            );
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_INTERNAL_ERROR]
            );
        }
        return json_encode($message);
    }

    public function login(LoginRequest $request)
    {
        if ($user = User::validate($request->input()))
        {
            $userId = $user->id;
            if ($token = AccessToken::createToken($userId))
            {
                $message = $this->getMessage('success',
                    [
                        'user_id'  => $userId,
                        'username' => $user->username,
                        'token'    => $token,
                    ]
                );
            }
            else
            {
                $message = $this->getMessage('error',
                    [Request::ERROR_DATABASE_INTERNAL_ERROR]
                );
            }
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_VALIDATE_USER_CREDENTIAL]
            );
        }
        return json_encode($message);
    }

    public function logout(LogoutRequest $request)
    {
        if ($loggedout = AccessToken::logout($request->input()))
        {
            $message = [
                'success' => [$loggedout],
            ];
        }
        return json_encode($message);
    }
}
