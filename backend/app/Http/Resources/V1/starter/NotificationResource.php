<?php

namespace App\Http\Resources\V1\starter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'message' => $this->message,
            'active' => $this->active,
            "target" => $this->target,
            "userId"=>$this->document_id,
            'user' => new userResource($this->whenLoaded('user')),
            'createdAt' => $this->created_at
        ];
    }
}
