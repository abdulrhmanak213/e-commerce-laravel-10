<?php

namespace App\Http\Requests\Admin\Contact;

use App\Http\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactRequest extends FormRequest
{
    use HttpResponse;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'phone'=>'required|string',
            'email'=>'required|email',
            'location'=>'required|in:sy,others',
            'store_location_ar'=>'required|string',
            'store_location_en'=>'required|string',
            'postcode_en'=>'required_if:location,others|string',
            'postcode_ar'=>'required_if:location,others|string',
        ];
    }

     public function failedValidation(Validator $validator)
     {
            throw new HttpResponseException(self::failure($validator->errors(),422));
     }
}
