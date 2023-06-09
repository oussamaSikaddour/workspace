<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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

            'user_id' => [
                'required',
                'exists:users,id'
            ],
            'content' => 'required|string|min:10|max:200',

        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "user_id" => $this->userId,
        ]);
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Le champ ID utilisateur est requis.',
            'user_id.exists' => 'L\'ID utilisateur fourni n\'existe pas dans notre système.',
            'content.required' => 'Le champ contenu est requis.',
            'content.string' => 'Le champ contenu doit être une chaîne de caractères.',
            'content.min' => 'Le champ contenu doit comporter au moins :min caractères.',
            'content.max' => 'Le champ contenu ne doit pas dépasser :max caractères.',
        ];
    }
}
