<?php

namespace App\Http\Requests\V1\workSpace;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOpeningHourRequest extends FormRequest
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
        return [
            'workspace_id' => ['required', 'exists:workspaces,id'],
            'day_of_week' => ['required', 'integer', 'between:0,6', Rule::unique('opening_hours')->where(function ($query) {
                return $query->where('workspace_id', $this->workspace_id);
            })],
            'open_time' => ['required', 'date_format:H:i:s'],
            'close_time' => ['required', 'date_format:H:i:s', 'after:open_time'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'workspace_id' => $this->workSpaceId,
            'day_of_week' => $this->dayOfWeek,
            'open_time' => $this->openTime,
            'close_time' => $this->closeTime,
        ]);
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
