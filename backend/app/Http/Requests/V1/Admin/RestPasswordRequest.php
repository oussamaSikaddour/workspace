<?php

namespace App\Http\Requests\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RestPasswordRequest extends FormRequest
{
    /**
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
            'email' => ['required', 'email', "exists:users,email"],
            'code' => ['required', 'max:6'],
            'password' =>  'required|confirmed|min:8|max:255'
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            "password_confirmation" => $this->passwordConfirmation
        ]);
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
            'email.exists' => 'L\'adresse e-mail fournie n\'est pas enregistrée.',
            'code.required' => 'Veuillez fournir un code OTP.',
            'code.max' => 'Le code OTP ne doit pas dépasser :max caractères.',
            'password.required' => 'Veuillez fournir un mot de passe.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'password.min' => 'Le mot de passe doit contenir au moins :min caractères.',
            'password.max' => 'Le mot de passe ne doit pas dépasser :max caractères.'
        ];
    }
}
