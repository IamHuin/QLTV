<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
            'title' => 'required|min:3',
            'content' => 'required|min:3',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => __('Field is required.'),
            'title.min' => __('Must be at least 3 characters.'),
            'content.required' => __('Field is required.'),
            'content.min' => __('Must be at least 3 characters.'),
            'image.image' => __('Format is invalid.'),
            'image.mimes' => __('Format is invalid.'),
            'image.max' => __('Max file size is 2 MB.'),
        ];
    }
}
