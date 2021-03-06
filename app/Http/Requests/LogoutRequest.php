<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Response;

class LogoutRequest extends Request
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
            'user_id' => 'required',
            'token'   => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => self::ERROR_VALIDATE_USER_ID_REQUIRED,
            'token.required'   => self::ERROR_VALIDATE_ACCESS_TOKEN_REQUIRED,
        ];
    }

    public function response(array $errors)
    {
        return Response::json($this->parseErrorMessage($errors), 200);
    }
}
