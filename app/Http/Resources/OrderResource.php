<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'drink_name' => $this->drink_name,
            'size' => $this->size,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'total_price' => $this->total_price,
            'temperature' => $this->temperature,
            'order_time' => date('Y-m-d H:i:s', strtotime($this->order_time)),
            'drink' => [
                'id' => $this->drink->id,
                'type' => $this->drink->type,
            ],
        ];
    }
}
