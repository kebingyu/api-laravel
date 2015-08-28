<?php

namespace App\Http\Controllers;

use App\Models\User as UserModel;
use App\Http\Controllers\Controller;
//use App\Http\Requests\ReadUserRequest;
use App\Http\Requests\UpdateUserRequest;

class User extends Controller
{
    public function read($key)
    {
        $message = [];
        if ($user = UserModel::findUserByPrimaryKey($key))
        {
            $message = [
                'user_found' => [
                    'username'   => $user->username,
                    'created at' => $user->created_at,
                ],
            ];
        }
        return json_encode($message);
    }

    public function update(UpdateUserRequest $request, $key)
    {
        $message = [];
        if ($user = UserModel::updateUser($request->input(), $key))
        {
            $message = [
                'user_updated' => [
                    'username'   => $user->username,
                    'updated at' => $user->updated_at,
                ],
            ];
        }
        return json_encode($message);
    }

    public function delete($key)
    {
        $message = [];
        if ($deleted = UserModel::deleteUser($key))
        {
            $message = [
                'user_deleted' => $deleted,
            ];
        }
        return json_encode($message);
    }
}
