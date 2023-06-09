<?php

namespace App\Http\Resources\V1\workSpace;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OpeningHourResource extends JsonResource
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
            'dayOfWeek' => $this->day_of_week,
            'openTime' => $this->open_time,
            'closeTime' => $this->close_time,
            'workspace' => new WorkspaceResource($this->whenLoaded('workspace')),
        ];
    }
}
