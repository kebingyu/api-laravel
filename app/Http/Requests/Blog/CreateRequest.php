<?php

namespace App\Http\Requests\Blog;

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
            'title'   => 'required',
            'content' => 'required',
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
            'title.required'   => self::ERROR_VALIDATE_BLOG_TITLE_REQUIRED,
            'content.required' => self::ERROR_VALIDATE_BLOG_CONTENT_REQUIRED,
        ];
    }

    public function response(array $errors)
    {
        return Response::json($this->parseErrorMessage($errors), 200);
    }
}
