<?php

namespace App\Http\Requests\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' =>  'required|confirmed|min:8|max:255',
            'new_password' =>  'required|confirmed|min:8|max:255',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "password_confirmation" => $this->passwordConfirmation
        ]);
        $this->merge([
            "new_password" => $this->newPassword
        ]);
        $this->merge([
            "new_password_confirmation" => $this->newPasswordConfirmation
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
            'password.required' => 'Le mot de passe actuel est requis.',
            'password.confirmed' => 'Le mot de passe actuel ne correspond pas à la confirmation.',
            'password.min' => 'Le mot de passe actuel doit comporter au moins :min caractères.',
            'password.max' => 'Le mot de passe actuel ne peut pas dépasser :max caractères.',
            'newPassword.required' => 'Le nouveau mot de passe est requis.',
            'newPassword.confirmed' => 'Le nouveau mot de passe ne correspond pas à la confirmation.',
            'newPassword.min' => 'Le nouveau mot de passe doit comporter au moins :min caractères.',
            'newPassword.max' => 'Le nouveau mot de passe ne peut pas dépasser :max caractères.',
        ];
    }
}
