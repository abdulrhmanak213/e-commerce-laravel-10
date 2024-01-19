<?php

namespace App\Http\Requests;

use App\Http\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactUsRequest extends FormRequest
{
    use HttpResponse;
    
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:50' ,
            'phone_or_email' => 'required|string' ,
            'message' => 'required|string'
        ];
    }

     public function failedValidation(Validator $validator)
     {
            throw new HttpResponseException(self::failure($validator->errors(),422));
     }
}
