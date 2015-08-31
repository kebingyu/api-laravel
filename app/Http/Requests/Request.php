<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    const ERROR_VALIDATE_USERNAME_REQUIRED     = 'Please give a user name.';
    const ERROR_VALIDATE_USERNAME_UNIQUE       = 'This user name is already taken.';
    const ERROR_VALIDATE_USERNAME_MAXLENGTH    = 'This user name exceeds max length.';
    const ERROR_VALIDATE_EMAIL_REQUIRED        = 'Please provide an email address.';
    const ERROR_VALIDATE_EMAIL_VALID           = 'Please provide an valid email address.';
    const ERROR_VALIDATE_EMAIL_UNIQUE          = 'This email address is already taken.';
    const ERROR_VALIDATE_EMAIL_MAXLENGTH       = 'This email address exceeds max length.';
    const ERROR_VALIDATE_PASSWORD_REQUIRED     = 'Please provide password.';
    const ERROR_VALIDATE_PASSWORD_CONFIRMED    = 'The passwords you provided do not match.';
    const ERROR_VALIDATE_USER_ID_REQUIRED      = 'User Id is required to proceed.';
    const ERROR_VALIDATE_ACCESS_TOKEN_REQUIRED = 'Access Token is required to proceed.';
    const ERROR_VALIDATE_ACCESS_TOKEN_EXPIRED  = 'Access Token expired.';

    const ERROR_VALIDATE_USER_CREDENTIAL       = 'Please re-enter your password.';

    const ERROR_DATABASE_INTERNAL_ERROR        = 'Internal error.';
    const ERROR_DATABASE_USER_NOT_FOUND        = 'User not found.';

    protected function parseErrorMessage(array $errors)
    {
        $message = [];
        foreach ($errors as $key => $value)
        {
            foreach ($value as $error)
            {
                $message[] = $error;
            }
        }
        return ['error' => $message];
    }
}
