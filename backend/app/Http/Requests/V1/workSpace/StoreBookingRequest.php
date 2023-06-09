<?php

namespace App\Http\Requests\V1\workSpace;

use App\Models\Workspace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
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
                'plan_id' => ['required', 'exists:plans,id'],
                'user_id' => ['required', 'exists:users,id'],
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:end_date',
                'start_time' => 'nullable|date_format:H:i:s',
                'end_time' => 'nullable|date_format:H:i:s|after:start_time',
                'payment_status' => ['sometimes', Rule::in(['inpayé', 'payé'])],
                'number_of_persons' => ['required', 'numeric'],
            ];

    }


    protected function prepareForValidation()
    {
        $data = [
            'workspace_id' => $this->workSpaceId,
            'plan_id' => $this->planId,
            'user_id' => $this->userId,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'number_of_persons' => $this->numberOfPersons,
        ];

        if ($this->paymentStatus) {
            $data['payment_status'] = $this->paymentStatus;
        }

        $this->merge($data);
    }

    public function messages()
    {
        return [
            'workspace_id.required' => 'Le champ ID de l\'espace de travail est requis.',
            'workspace_id.exists' => 'L\'ID de l\'espace de travail spécifié n\'existe pas.',
            'plan_id.required' => 'Le champ ID du planning est requis.',
            'plan_id.exists' => 'le planning spécifié n\'existe pas.',
            'user_id.required' => 'Le champ ID de l\'utilisateur est requis.',
            'user_id.exists' => 'L\'ID de l\'utilisateur spécifié n\'existe pas.',
            'start_date.required' => 'Le champ Date de début est requis.',
            'start_date.date' => 'Le champ Date de début doit être une date valide.',
            'end_date.required' => 'Le champ Date de fin est requis.',
            'end_date.date' => 'Le champ Date de fin doit être une date valide.',
            'end_date.after_or_equal' => 'Le champ Date de fin doit être égale ou postérieure à la date de début.',
            'start_time.date_format' => 'Le champ Heure de début doit être au format H:i:s.',
            'end_time.date_format' => 'Le champ Heure de fin doit être au format H:i:s.',
            'end_time.after' => 'Le champ Heure de fin doit être postérieure à l\'heure de début.',
            'payment_status.in' => 'Le champ Statut de paiement doit être soit "inpayé" soit "payé".',
            'number_of_persons.required' => 'Le champ Nombre de personnes est requis.',
            'number_of_persons.numeric' => 'Le champ Nombre de personnes doit être numérique.',
        ];
    }
}
