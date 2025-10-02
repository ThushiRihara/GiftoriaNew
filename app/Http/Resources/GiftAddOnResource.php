<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GiftAddOnResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'gift' => new GiftResource($this->whenLoaded('gift')),
            'add_on' => new AddOnResource($this->whenLoaded('addOn')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
