<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ValidationResponsable
{
    use ApiResponsable;
    public function failedValidation(Validator $validator): HttpResponseException
    {
        $messages = [];

        foreach ($validator->errors()->messages() as $fieldMessages) {
            $messages = array_merge($messages, $fieldMessages);
        }

        throw new HttpResponseException($this->respondFailedValidation(
            array_unique($messages)
        ));
    }
}
