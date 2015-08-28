<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Response;
use App\Models\User;
use Auth;

class ReadUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return User::find(Auth::id())->is_active == 1;
    }

    public function rules()
    {
        return [];
    }

    public function response(array $errors)
    {
        return Response::json($errors, 400);
    }
}
