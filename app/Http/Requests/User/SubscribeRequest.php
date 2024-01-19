<?php

namespace App\Http\Requests\User;

use App\Http\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubscribeRequest extends FormRequest
{
    use HttpResponse;
 
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => 'required|string'
        ];
    }

     public function failedValidation(Validator $validator)
     {
            throw new HttpResponseException(self::failure($validator->errors(),422));
     }
}
