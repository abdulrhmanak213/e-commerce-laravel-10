<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Traits\HttpResponse;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        if (request()->method() == 'POST') {
            return [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|confirmed',
                'city_id' => 'required|string|exists:cities,id',
                'phone' => 'required|string',
                'address' => 'sometimes|string',
            ];
        }
        else {
            return [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user)],
                'city_id' => 'required|string|exists:cities,id',
                'phone' => 'required|string',
                'address' => 'sometimes|string',
            ];
        }
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(self::failure($validator->errors(), 422));
    }
}
