<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'sometimes|email|max:64|unique:user',
            'password'  => 'sometimes|confirmed|min:6',
            'is_active' => 'sometimes|numeric',
            'is_admin'  => 'sometimes|numeric',
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    public function response(array $errors)
    {
        return Response::json($errors, 400);
    }
}
