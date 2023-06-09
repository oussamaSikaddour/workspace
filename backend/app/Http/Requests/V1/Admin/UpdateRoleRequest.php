<?php

namespace App\Http\Requests\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
        $method = $this->method();
        if ($method == "PUT") {
            return [
                'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $this->role->id],
                'slug' => ['required', 'string', 'max:255', 'unique:roles'],

            ];
        } else {
            return [
                'name' => ["sometimes", 'required', 'string', 'max:255', 'unique:roles,name,' . $this->role->id],
                'slug' => ["sometimes", 'required', 'string', 'max:255', 'unique:roles']
            ];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => "Le nom est obligatoire.",
            'name.string' => "Le nom doit être une chaîne de caractères.",
            'name.max' => "Le nom ne doit pas dépasser :max caractères.",
            'name.unique' => "Ce nom est déjà utilisé.",
            'slug.required' => "Le slug est obligatoire.",
            'slug.string' => "Le slug doit être une chaîne de caractères.",
            'slug.max' => "Le slug ne doit pas dépasser :max caractères.",
            'slug.unique' => "Ce slug est déjà utilisé."
        ];
    }
}
