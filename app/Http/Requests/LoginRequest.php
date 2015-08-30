<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Response;

class LoginRequest extends Request
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
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => self::ERROR_VALIDATE_USERNAME_REQUIRED,
            'password.required' => self::ERROR_VALIDATE_PASSWORD_REQUIRED,
        ];
    }

    public function response(array $errors)
    {
        return Response::json($this->parseErrorMessage($errors), 200);
    }
}
