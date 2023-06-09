<?php

namespace App\Http\Requests\V1\workSpace;

use App\Models\DayOff;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDayOffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
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
        $workspaceId = $this->input('workspace_id');
        $currentDayOffId = $this->route('dayOff') ? $this->route('dayOff')->id : null;
        $method = $this->method();

        $commonRules = [
            'workspace_id' => ['sometimes', 'exists:workspaces,id'],
            'days_off_start' => [
                'sometimes',
                'date',
                function ($attribute, $value, $fail) use ($workspaceId, $currentDayOffId) {
                    $existingDayOff = DayOff::where('workspace_id', $workspaceId)
                        ->where('id', '!=', $currentDayOffId)
                        ->where(function ($query) use ($value) {
                            $query->where('days_off_start', '<=', $value)
                                ->where('days_off_end', '>=', $value);
                        })
                        ->first();

                    if ($existingDayOff) {
                        $fail('Des jours de congé existent déjà pour la date de début indiquée.');
                    }
                },
            ],
            'days_off_end' => [
                'sometimes',
                'date',
                'after_or_equal:days_off_start',
                function ($attribute, $value, $fail) use ($workspaceId, $currentDayOffId) {
                    $existingDayOff = DayOff::where('workspace_id', $workspaceId)
                        ->where('id', '!=', $currentDayOffId)
                        ->where(function ($query) use ($value) {
                            $query->where('days_off_start', '<=', $value)
                                ->where('days_off_end', '>=', $value);
                        })
                        ->first();

                    if ($existingDayOff) {
                        $fail('Des jours de congé existent déjà pour la date de fin indiquée.');
                    }
                },
            ],
        ];

        if ($method === 'PUT') {

            return array_map(function ($rules) {
                return array_merge(['required'], $rules);
            }, $commonRules);

        }

        return $commonRules;

    }


    protected function prepareForValidation()
    {
        $data = [];

        if ($this->has('workSpaceId')) {
            $data['workspace_id'] = $this->workSpaceId;
        }

        if ($this->has('daysOffStart')) {
            $data['days_off_start'] = $this->daysOffStart;
        }

        if ($this->has('daysOffEnd')) {
            $data['days_off_end'] = $this->daysOffEnd;
        }

        $this->merge($data);
    }

    public function messages(): array
    {
        return [
            'workspace_id.required' => 'Le champ ID de l\'espace de travail est requis.',
            'workspace_id.exists' => 'L\'ID de l\'espace de travail spécifié n\'existe pas.',
            'days_off_start.required' => 'Le champ Date de début est requis.',
            'days_off_start.date' => 'Le champ Date de début doit être une date valide.',
            'days_off_start.unique' => 'La date de début des congés existe déjà pour cet espace de travail.',
            'days_off_start.before_or_equal' => 'La date de début doit être antérieure ou égale à la date de fin des congés.',
            'days_off_end.required' => 'Le champ Date de fin est requis.',
            'days_off_end.date' => 'Le champ Date de fin doit être une date valide.',
            'days_off_end.after_or_equal' => 'La date de fin doit être postérieure ou égale à la date de début des congés.',
            'days_off_end.unique' => 'La date de fin des congés existe déjà pour cet espace de travail.',
        ];
    }
}
