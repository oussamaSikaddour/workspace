<?php

namespace App\Http\Requests\V1\workSpace;

use App\Models\Workspace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $workspaceId = $this->input('workspace_id');

        // Retrieve the workspace to calculate the maximum capacity constraint
        $workspace = Workspace::findOrFail($workspaceId);

        $placesFilled = $workspace->plans()
            ->where(function ($query) use ($workspaceId) {
                $query->where('workspace_id', $workspaceId)
                    ->where(function ($query) {
                        $query->whereDate('start_date', '<=', $this->input('start_date'))
                            ->whereDate('end_date', '>=', $this->input('start_date'));
                    })
                    ->orWhere(function ($query) {
                        $query->whereDate('start_date', '<=', $this->input('end_date'))
                            ->whereDate('end_date', '>=', $this->input('end_date'));
                    });
            })
            ->sum('capacity');

        $maxCapacity = $workspace->capacity - $placesFilled;

        return [
            'workspace_id' => ['required', 'exists:workspaces,id'],
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'capacity' => ['required', 'integer', 'min:1', "lte:$maxCapacity"],
            'status' => ['required', Rule::in(['inactive', 'active'])],
        ];
    }





    protected function prepareForValidation()
    {
        $this->merge([
            'workspace_id' => $this->workSpaceId,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,

        ]);
    }

    public function messages()
    {
        return [
            'workspace_id.required' => 'Le champ ID de l\'espace de travail est requis.',
            'workspace_id.exists' => 'L\'ID de l\'espace de travail spécifié n\'existe pas.',
            'start_date.required' => 'Le champ Date de début est requis.',
            'start_date.date' => 'Le champ Date de début doit être une date valide.',
            'end_date.required' => 'Le champ Date de fin est requis.',
            'end_date.date' => 'Le champ Date de fin doit être une date valide.',
            'capacity.required' => 'Le champ Capacité est requis.',
            'capacity.integer' => 'Le champ Capacité doit être un entier.',
            'capacity.min' => 'Le champ Capacité doit être d\'au moins :min.',
            'capacity.lte' => 'Le champ Capacité doit être inférieur ou égal à la capacité maximale.',
            'status.required' => 'Le champ Statut est requis.',
            'status.in' => 'Le champ Statut doit être soit "inactive" soit "active".',
        ];
    }


}

