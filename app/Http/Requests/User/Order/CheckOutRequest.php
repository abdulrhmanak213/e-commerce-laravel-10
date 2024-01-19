<?php

namespace App\Http\Requests\User\Order;

use App\Http\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CheckOutRequest extends FormRequest
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
            'first_name' => 'required|string|max:50' ,
            'last_name' => 'required|string|max:50' ,
            'country_id' => 'required|exists:countries,id' ,
            'city_id' => 'required|exists:cities,id' ,
            'state' => 'required|string' ,
            'street' => 'required|string' ,
            'phone' => 'required|numeric' ,
            'email' => 'required|email' ,
            'note' => 'string' ,
            'cart_id' => 'required|exists:carts,id',
            's_id' => ['string', Rule::when(!request()->user('user'), 'required')]
        ];
    }

     public function failedValidation(Validator $validator)
     {
            throw new HttpResponseException(self::failure($validator->errors(),422));
     }
}
