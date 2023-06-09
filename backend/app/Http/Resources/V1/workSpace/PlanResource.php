<?php

namespace App\Http\Resources\V1\workSpace;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
                'workSpaceId' => $this->workspace_id,
                'startDate' => $this->start_date,
                'endDate' => $this->end_date,
                'capacity' => $this->capacity,
                'status' => $this->status,
                'workspace' => new WorkspaceResource($this->whenLoaded('workspace')),
                'bookings' => BookingResource::collection($this->whenLoaded('bookings')),
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ];

    }
}
