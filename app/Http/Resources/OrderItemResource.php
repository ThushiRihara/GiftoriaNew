<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'quantity' => $this->quantity,
            'price' => $this->price,
            'add_ons' => OrderItemAddOnResource::collection($this->whenLoaded('addOns')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
