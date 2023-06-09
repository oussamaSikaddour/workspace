<?php

namespace App\Http\Requests\V1\workSpace;

use App\Models\DayOff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDayOffRequest extends FormRequest
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
        $workspaceId = $this->input('workspace_id');

        return [
            'workspace_id' => ['required', 'exists:workspaces,id'],
            'days_off_start' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($workspaceId) {
                    $existingDayOff = DayOff::where('workspace_id', $workspaceId)
                        ->where(function ($query) use ($value) {
                            $query->where('days_off_start', '<=', $value)
                                ->where('days_off_end', '>=', $value);
                        })
                        ->first();

                    if ($existingDayOff) {
                        $fail('des jours de congé existe déjà pour la date de début indiquée.');
                    }
                },
            ],
            'days_off_end' => [
                'required',
                'date',
                'after_or_equal:days_off_start',
                function ($attribute, $value, $fail) use ($workspaceId) {
                    $existingDayOff = DayOff::where('workspace_id', $workspaceId)
                        ->where(function ($query) use ($value) {
                            $query->where('days_off_start', '<=', $value)
                                ->where('days_off_end', '>=', $value);
                        })
                        ->first();

                    if ($existingDayOff) {
                        $fail('des jour de congé existe déjà pour la date de fin indiquée.');
                    }
                },
            ],
        ];
    }


    protected function prepareForValidation()
    {
        $this->merge([
            'workspace_id' => $this->workSpaceId,
            'days_off_start' => $this->daysOffStart,
            'days_off_end' => $this->daysOffEnd,
        ]);
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
