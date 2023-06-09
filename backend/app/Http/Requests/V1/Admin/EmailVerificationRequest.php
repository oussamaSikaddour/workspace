<?php

namespace App\Http\Requests\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmailVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "email" => ["required", "email", "exists:users"],
            "code" => ["required", "max:6"]
        ];
    }



    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Veuillez fournir une adresse e-mail.',
            'email.email' => 'L\'adresse e-mail doit être valide.',
            'email.exists' => 'L\'adresse e-mail fournie n\'existe pas.',
            'code.required' => 'Veuillez fournir le code de vérification',
            'code.max' => ' le code de vérification ne doit pas dépasser :max caractères.',
        ];
    }
}
