<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|min:3|max:30|unique:users,username',
            'password' => 'required|min:3|max:30',
            'email' => 'required|email|unique:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => __('Field is required.'),
            'username.min' => __('Must be at least 3 characters.'),
            'username.max' => __('May not be greater than 30 characters.'),
            'password.required' => __('Field is required.'),
            'password.min' => __('Must be at least 3 characters.'),
            'password.max' => __('May not be greater than 30 characters.'),
            'email.required' => __('Field is required.'),
            'email.email' => __('Format is invalid.'),
            'email.unique' => __('Must be unique.'),
        ];
    }
}
