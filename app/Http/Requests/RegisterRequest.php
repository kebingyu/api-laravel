<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Response;

class RegisterRequest extends Request
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
            'username' => 'required|max:64|unique:user',
            'email'    => 'required|email|max:64|unique:user',
            'password' => 'required|confirmed|min:6',
        ];
    }

    /**
     * Customized error message. 
     * 
     * @return array
     */
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
