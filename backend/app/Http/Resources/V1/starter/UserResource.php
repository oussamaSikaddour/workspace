<?php

namespace App\Http\Resources\V1\starter;

use App\Http\Resources\V1\workSpace\BookingResource;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'abilities' => $this->roles->pluck('slug'),
            'personnelInfo' => new PersonnelInfoResource($this->whenLoaded('personnelInfo')),
            'education' => new EducationResource($this->whenLoaded('education')),
            'occupation' => new OccupationResource($this->whenLoaded('occupation')),
            "messages" => MessageResource::collection($this->whenLoaded("messages")),
            "bookings" =>BookingResource::collection($this->whenLoaded("bookings")),
        ];
    }
}
