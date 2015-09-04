<?php

namespace App\Http\Requests\Tag;

use App\Http\Requests\Request;
use Response;

class CreateRequest extends Request
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
            'content' => 'required',
            'blog_id' => 'required',
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
            'content.required' => self::ERROR_VALIDATE_TAG_CONTENT_REQUIRED,
            'blog_id.required' => self::ERROR_VALIDATE_TAG_BLOG_ID_REQUIRED,
        ];
    }

    public function response(array $errors)
    {
        return Response::json($this->parseErrorMessage($errors), 200);
    }
}
