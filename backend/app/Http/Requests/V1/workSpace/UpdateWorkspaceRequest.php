<?php

namespace App\Http\Requests\V1\workSpace;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkspaceRequest extends FormRequest
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
            $method = $this->method();
            $workspaceId = $this->route('workspace');
            if ($method == "PUT") {
                return [
                    'name' => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('workspaces')->ignore($workspaceId),
                    ],
                    'description' => 'nullable|string',
                    'location' => 'required|string|max:255',
                    'capacity' => 'required|integer|min:0',
                    'price_per_hour' => 'required|numeric|min:0',
                ];

            } else {
            return [
                'name' => [
                    'sometimes',
                    'string',
                    'max:255',
                    Rule::unique('workspaces')->ignore($workspaceId),
                ],
            'description' => 'sometimes|string',
            'location' => 'sometimes|string|max:255',
            'capacity' => 'sometimes|integer|min:0',
            'price_per_hour' => 'sometimes|numeric|min:0',
        ];

            }

    }


    protected function prepareForValidation()
    {        if($this->pricePerHour){
            $this->merge(['price_per_hour' => $this->pricePerHour]);
    }
    }
    public function messages(): array
{
    return [
        'name.required' => 'Le champ Nom est requis.',
        'name.string' => 'Le champ Nom doit être une chaîne de caractères.',
        'name.max' => 'Le champ Nom ne peut pas dépasser :max caractères.',
        'description.string' => 'Le champ Description doit être une chaîne de caractères.',
        'location.required' => 'Le champ Emplacement est requis.',
        'location.string' => 'Le champ Emplacement doit être une chaîne de caractères.',
        'location.max' => 'Le champ Emplacement ne peut pas dépasser :max caractères.',
        'capacity.required' => 'Le champ Capacité est requis.',
        'capacity.integer' => 'Le champ Capacité doit être un nombre entier.',
        'capacity.min' => 'Le champ Capacité doit être supérieur ou égal à :min.',
        'price_per_hour.required' => 'Le champ Prix par heure est requis.',
        'price_per_hour.numeric' => 'Le champ Prix par heure doit être un nombre.',
        'price_per_hour.min' => 'Le champ Prix par heure doit être supérieur ou égal à :min.',
    ];
}


}
