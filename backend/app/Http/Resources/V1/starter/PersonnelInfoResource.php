<?php

namespace App\Http\Resources\V1\starter;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonnelInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'lastName' => $this->last_name,
            'firstName' => $this->first_name,
            'cardNumber' => $this->card_number,
            'birthPlace' => $this->birth_place,
            'birthDate' => $this->birth_date,
            'addresses' => $this->addresses,
            'user' => new UserResource($this->whenLoaded('user')),
            'tel' => $this->tel,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
