<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddOnResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'gifts' => GiftResource::collection($this->whenLoaded('gifts')),
            'order_items' => $this->whenLoaded('orderItems'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}