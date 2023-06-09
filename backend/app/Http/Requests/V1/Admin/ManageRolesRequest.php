<?php

namespace App\Http\Requests\V1\Admin;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManageRolesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'exists:users,id'
            ],
            'abilities.*' => [
                'required',
                 Rule::exists(Role::class, 'slug'),
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "user_id" => $this->userId
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
            'user_id.required' => 'L\'ID utilisateur est obligatoire.',
            'user_id.exists' => 'L\'ID utilisateur fourni n\'existe pas.',
            'abilities.*.required' => 'Les rôles sont obligatoires.',
            'abilities.*.exists' => 'Le rôle sélectionné est invalide.',
        ];
    }
}
