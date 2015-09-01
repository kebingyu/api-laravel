<?php

namespace App\Http\Controllers;

use App\Models\User as UserModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Http\Requests\UpdateUserRequest;

class User extends Controller
{
    public function read($key)
    {
        if ($user = UserModel::findUserByPrimaryKey($key))
        {
            $message = $this->getMessage('success', [
                'username'   => $user->username,
                'email'      => $user->email,
                'created_at' => $user->created_at,
            ]);
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_USER_NOT_FOUND]
            );
        } 
        return json_encode($message);
    }

    public function update(UpdateUserRequest $request, $key)
    {
        if ($user = UserModel::updateUser($request->input(), $key))
        {
            $message = $this->getMessage('success', [
                'username'   => $user->username,
                'updated at' => $user->updated_at,
            ]);
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_USER_NOT_FOUND]
            );
        } 
        return json_encode($message);
    }

    public function delete($key)
    {
        if ($deleted = UserModel::deleteUser($key))
        {
            $message = $this->getMessage('success', [
                $deleted,
            ]);
        }
        else
        {
            $message = $this->getMessage('error',
                [Request::ERROR_DATABASE_USER_NOT_FOUND]
            );
        } 
        return json_encode($message);
    }
}
