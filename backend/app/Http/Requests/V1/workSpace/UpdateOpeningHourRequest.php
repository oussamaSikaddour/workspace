<?php

namespace App\Http\Requests\V1\workSpace;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOpeningHourRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $commonRules = [
            'workspace_id' => ['sometimes', 'exists:workspaces,id'],
            'day_of_week' => ['sometimes', 'integer', 'between:0,6', Rule::unique('opening_hours')->where(function ($query) {
                return $query->where('workspace_id', $this->workspace_id);
            })->ignore($this->openingHour->id)],
            'open_time' => ['sometimes', 'date_format:H:i:s'],
            'close_time' => ['sometimes', 'date_format:H:i:s', 'after:open_time'],
        ];

        if ($this->isMethod('PUT')) {
            return array_map(fn($rules) => array_merge(['required'], $rules), $commonRules);
        }

        return $commonRules;
    }

    protected function prepareForValidation()
    {
        $data = [];

        if ($this->filled('workSpaceId')) {
            $data['workspace_id'] = $this->input('workSpaceId');
        }

        if ($this->filled('dayOfWeek')) {
            $data['day_of_week'] = $this->input('dayOfWeek');
        }

        if ($this->filled('openTime')) {
            $data['open_time'] = $this->input('openTime');
        }

        if ($this->filled('closeTime')) {
            $data['close_time'] = $this->input('closeTime');
        }

        $this->merge($data);
    }

    public function messages(): array
    {
        return [
            'workspace_id.required' => 'Le champ ID de l\'espace de travail est requis.',
            'workspace_id.exists' => 'L\'ID de l\'espace de travail spécifié n\'existe pas.',
            'day_of_week.required' => 'Le champ Jour de la semaine est requis.',
            'day_of_week.integer' => 'Le champ Jour de la semaine doit être un entier.',
            'day_of_week.between' => 'Le champ Jour de la semaine doit être compris entre 0 et 6.',
            'day_of_week.unique' => 'Ce jour de la semaine est déjà défini pour cet espace de travail.',
            'open_time.required' => 'Le champ heure d\'ouverture est requis.',
            'open_time.date_format' => 'Le champ heure d\'ouverture doit être au format H:i:s.',
            'close_time.required' => 'Le champ heure de fermeture est requis.',
            'close_time.date_format' => 'Le champ heure de fermeture doit être au format H:i:s.',
            'close_time.after' => 'Le champ heure de fermeture doit être postérieur à l\'heure d\'ouverture.',
        ];
    }
}
