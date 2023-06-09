<?php

namespace App\Http\Resources\V1\starter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OccupationResource extends JsonResource
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
            'experience' => $this->experience,
            "field" => $this->field,
            "grade" => $this->grade,
            "specialty" => $this->specialty,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
