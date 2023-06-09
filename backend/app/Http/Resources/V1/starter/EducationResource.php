<?php

namespace App\Http\Resources\V1\starter;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'entitled' => $this->entitled,
            'degree' => $this->degree,
            'institution' => $this->institution,
            'fieldOfStudy' => $this->field_of_study,
            'graduationDate' => $this->graduation_date,
            'placeOfGraduation' => $this->place_of_graduation,
            'user' => new UserResource($this->whenLoaded('user')),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
