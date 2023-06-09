<?php

namespace App\Http\Resources\V1\workSpace;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkSpaceResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'capacity' => $this->capacity,
            'pricePerHour' => $this->price_per_hour,
            'plans' => PlanResource::collection($this->whenLoaded('plans')),
            'bookings' => BookingResource::collection($this->whenLoaded('bookings')),
            'daysOff' => DayOffResource::collection($this->whenLoaded('daysOff')),
            'openingHours' => OpeningHourResource::collection($this->whenLoaded('openingHours')),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
