<?php

namespace App\Http\Requests\V1\workSpace;

use App\Models\Workspace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlanRequest extends FormRequest
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
        $currentPlan = $this->route('plan') ? $this->route('plan') : null;

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

        $maxCapacity = $workspace->capacity + $currentPlan->capacity - $placesFilled;



        $commonRules = [
            'workspace_id' => ['sometimes', 'exists:workspaces,id'],
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'capacity' => ['sometimes', 'integer', 'min:1', "lte:$maxCapacity"],
            'status' => ['sometimes', Rule::in(['inactive', 'active'])],
        ];

        $method = $this->method();
        if ($method === 'PUT') {
            $commonRules = array_map(function ($rules) {
                return array_merge(['required'], $rules);
            }, $commonRules);
        }

        return $commonRules;
    }


    protected function prepareForValidation()
    {
        $data = [];

        if ($this->filled('workSpaceId')) {
            $data['workspace_id'] = $this->input('workSpaceId');
        }

        if ($this->filled('startDate')) {
            $data['start_date'] = $this->input('startDate');
        }
        if ($this->filled('endDate')) {
            $data['end_date'] = $this->input('endDate');
        }

        $this->merge($data);
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
