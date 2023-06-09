<?php

namespace App\Http\Resources\V1\starter;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'content' => $this->content,
            'state' => $this->state,
            'user' => new UserResource($this->whenLoaded('user')),
            'createdAt' => $this->created_at
        ];
    }
}
