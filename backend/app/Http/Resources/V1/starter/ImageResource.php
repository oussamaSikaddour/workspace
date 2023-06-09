<?php

namespace App\Http\Resources\V1\starter;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "path" => $this->path,
            "url" => $this->url,
            "size" => round($this->size / 1048576, 2),
            "width" => $this->width,
            "height" => $this->height,
            "status" => $this->status,
            "useCase" => $this->use_case,
            "imageableId" => $this->imageable_id,
            "imageableType" => $this->imageable_type,
        ];
    }
}
