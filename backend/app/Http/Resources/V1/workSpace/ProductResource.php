<?php

namespace App\Http\Resources\V1\workspace;

use App\Http\Resources\V1\starter\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'price' => $this->price,
            'status' => $this->status,
            "images" => ImageResource::collection($this->whenLoaded("images")),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
