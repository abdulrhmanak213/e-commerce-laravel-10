<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
{
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
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric|digits:10',
                'password' => 'required|string|min:8',
                'confirm_password' => 'required|same:password|string|min:8',
            ];
        }
        else
            return [
                'first_name' => 'required|string',
                'last_name' => 'required|string|max:100',
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->admin)],
                'phone' => 'required|numeric|digits:10',
            ];
    }
}
