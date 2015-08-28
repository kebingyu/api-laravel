<?php

namespace App\Http\Controllers;

use App\Models\User as UserModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;

class User extends Controller
{
    public function get($key)
    {
        $message = [];
        if ($user = $this->findUserByPrimaryKey($key))
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

    public function update(UpdateUserRequest $request, $key)
    {
        $message = [];
        if ($user = $this->findUserByPrimaryKey($key))
        {
            $data = $request->input();
            if (isset($data['password']))
            {
                $data['password'] = bcrypt($data['password']);
            }
            $updated = $user->update($data);
            if ($updated)
            {
                $message = [
                    'user_updated' => [
                        'username' => $user->username,
                        'updated at' => $user->updated_at,
                    ],
                ];
            }
        }
        return json_encode($message);
    }

    public function delete($key)
    {
        $message = [];
        if ($user = $this->findUserByPrimaryKey($key))
        {
            $message = [
                'user_deleted' => $user->delete(),
            ];
        }
        return json_encode($message);
    }

    public function login($data)
    {
    }

    public function logout()
    {
    }

    protected function findUserByPrimaryKey($key)
    {
        if (is_numeric($key))
        {
            $user = UserModel::find($key);
        }
        else if ($this->isValidEmail($key))
        {
            $user = UserModel::where('email', $key)->first();
        }
        else
        {
            $user = UserModel::where('username', $key)->first();
        }
        return $user;
    }

    protected function isValidEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}
