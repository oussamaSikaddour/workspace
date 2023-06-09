<?php

namespace App\Http\Requests\V1\workSpace;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserMessageRequest extends FormRequest
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
     * @return array
     */
    public function rules():array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tel' => [
                'required',
                'regex:/^(05|06|07)\d{8}$/',
            ],
            'message' => 'required|string',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages():array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name field may not be greater than :max characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email field may not be greater than :max characters.',
            'tel.required' => 'The tel field is required.',
            'tel.string' => 'The tel field must be a string.',
            'tel.max' => 'The tel field may not be greater than :max characters.',
            'message.required' => 'The message field is required.',
            'message.string' => 'The message field must be a string.',
        ];
    }
}
