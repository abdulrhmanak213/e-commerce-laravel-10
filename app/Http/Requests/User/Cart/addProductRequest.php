<?php

namespace App\Http\Requests\User\Cart;

use App\Http\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class addProductRequest extends FormRequest
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
            's_id' => ['string',Rule::when(! request()->user('user'),'required')],
            'quantity'=>'required|integer|gt:0' ,
            'color' => 'required|exists:colors,id',
            'size' => 'required|exists:product_sizes,id' 
        ];
    }

     public function failedValidation(Validator $validator)
     {
            throw new HttpResponseException(self::failure($validator->errors(),422));
     }
}
