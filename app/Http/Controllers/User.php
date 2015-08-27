<?php

namespace App\Http\Controllers;

use App\Models\User as UserModel;
use App\Http\Controllers\Controller;

class User extends Controller
{
    public function get($key)
    {
        if (is_numeric($key))
        {
            $user = UserModel::find($key);
        }
        /**
         * Todo: what if username contains "@"? 
         */
        else if (strpos($key, '@') !== false)
        {
            $user = UserModel::where('email', $key)->first();
        }
        else
        {
            $user = UserModel::where('username', $key)->first();
        }

        $message = [];
        if ($user)
        {
            $message = [
                'user_found' => [
                    'username' => $user->username,
                    'created at' => $user->created_at,
                ],
            ];
        }
        return json_encode($message); 
    }

    public function update($id)
    {
    }

    public function delete($id)
    {
        return json_encode([
            'deleted' => [
                'id' => $id,
            ],
        ]);
    }

    public function login($data)
    {
    }

    public function logout()
    {
    }
}
