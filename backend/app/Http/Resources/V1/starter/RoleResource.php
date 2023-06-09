<?php

namespace App\Http\Resources\V1\starter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "users" => UserResource::collection($this->whenLoaded("users")),
            'attachedAt' => $this->whenPivotLoaded('role_user', function () {
                return $this->pivot->created_at;
            }),

        ];
    }
}
