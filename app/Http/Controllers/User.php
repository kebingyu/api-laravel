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
            $message = $this->getUserById($key);
        }
        /**
         * Todo: what if username contains "@"? 
         */
        else if (strpos($key, '@') !== false)
        {
            $message = $this->getUserByEmail($key);
        }
        else
        {
            $message = $this->getUserByUsername($key);
        }
        return json_encode($message); 
    }

    protected function getUserById($id)
    {
        if ($user = UserModel::find($id))
        {
            return [
                'user_found' => [
                    'username' => $user->username,
                    'created at' => $user->created_at,
                ],
            ];
        }
        return [];
    }

    protected function getUserByEmail($email)
    {
        if ($user = UserModel::where('email', $email)->first())
        {
            return [
                'user_found' => [
                    'username' => $user->username,
                    'created at' => $user->created_at,
                ],
            ];
        }
        return [];
    }

    protected function getUserByUsername($name)
    {
        if ($user = UserModel::where('username', $name)->first())
        {
            return [
                'user_found' => [
                    'username' => $user->username,
                    'created at' => $user->created_at,
                ],
            ];
        }
        return [];
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
