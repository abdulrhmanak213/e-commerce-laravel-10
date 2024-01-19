<?php

namespace App\Http\Requests\Admin\Product;

use App\Http\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|integer|exists:categories,id',
            'cover' => 'required_without:_method|file|mimes:jpeg,png,jpg,gif,svg,webp',
            'images' => 'array|required_without:_method',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
            'color_ids' => 'array|required',
            'color_ids.*' => 'exists:colors,id',
            'sizes' => 'array|required',
            'sizes.*' => 'distinct|in:xs,s,m,l,xl,xxl,3xl',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(self::failure($validator->errors(), 422));
    }
}
