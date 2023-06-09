<?php

namespace App\Http\Resources\V1\workSpace;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DayOffResource extends JsonResource
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
            'daysOffStart' => $this->days_off_start,
            'daysOffEnd' => $this->days_off_end,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
