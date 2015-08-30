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
            'username.required'  => self::ERROR_VALIDATE_USERNAME_REQUIRED,
            'username.max'       => self::ERROR_VALIDATE_USERNAME_MAXLENGTH,
            'username.unique'    => self::ERROR_VALIDATE_USERNAME_UNIQUE,
            'email.required'     => self::ERROR_VALIDATE_EMAIL_REQUIRED,
            'email.email'        => self::ERROR_VALIDATE_EMAIL_VALID,
            'email.max'          => self::ERROR_VALIDATE_EMAIL_MAXLENGTH,
            'email.unique'       => self::ERROR_VALIDATE_EMAIL_UNIQUE,
            'password.required'  => self::ERROR_VALIDATE_PASSWORD_REQUIRED,
            'password.confirmed' => self::ERROR_VALIDATE_PASSWORD_CONFIRMED,
        ];
    }

    public function response(array $errors)
    {
        return Response::json($this->parseErrorMessage($errors), 200);
    }
}
