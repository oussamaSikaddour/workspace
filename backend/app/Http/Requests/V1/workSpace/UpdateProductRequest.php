<?php

namespace App\Http\Requests\V1\workSpace;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {



        $commonRules = [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'status' => 'sometimes|in:active,inactive',
            'images' => 'sometimes|array|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $method = $this->method();
        if ($method === 'PUT') {
            $commonRules = array_map(function ($rules) {
                return array_merge(['required'], $rules);
            }, $commonRules);
        }

        return $commonRules;
    }


    public function messages()
    {
        return [
            'name.required' => 'Le champ "Nom" est obligatoire.',
            'name.string' => 'Le champ "Nom" doit être une chaîne de caractères.',
            'name.max' => 'Le champ "Nom" ne doit pas dépasser :max caractères.',
            'description.required' => 'Le champ "Description" est obligatoire.',
            'description.string' => 'Le champ "Description" doit être une chaîne de caractères.',
            'price.required' => 'Le champ "Prix" est obligatoire.',
            'price.numeric' => 'Le champ "Prix" doit être un nombre.',
            'status.required' => 'Le champ "État" est obligatoire.',
            'status.in' => 'Le champ "État" doit être "actif" ou "inactif".',
            'images.array' => 'Le champ "Images" doit être un tableau.',
            'images.*.image' => 'Les fichiers du champ "Images" doivent être des images.',
            'images.*.mimes' => 'Les fichiers du champ "Images" doivent être au format :values.',
            'images.*.max' => 'Les fichiers du champ "Images" ne doivent pas dépasser :max kilo-octets.',
            'images.max' => 'Le champ "Images" ne doit pas contenir plus de :max éléments.', // New message for maximum length
        ];
    }

}
