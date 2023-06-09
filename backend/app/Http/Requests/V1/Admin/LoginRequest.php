<?php

namespace App\Http\Requests\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' =>  'required|min:8|max:255'
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
            'email.string' => 'L\'e-mail doit être une chaîne de caractères.',
            'email.email' => 'Veuillez fournir une adresse e-mail valide.',
            'password.required' => 'Veuillez fournir un mot de passe.',
            'password.min' => 'Le mot de passe doit comporter au moins :min caractères.',
            'password.max' => 'Le mot de passe ne doit pas dépasser :max caractères.'
        ];
    }
}
