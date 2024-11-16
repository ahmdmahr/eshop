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
            'order_number' => $this->order_number,
            'user_id' => $this->user_id,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
            'coupon' => $this->coupon,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'condtion' => $this->condtion,
            'delivery_charge' => $this->delivery_charge,
            'notes' => $this->notes,
            'payment_details' => $this->payment_details,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'items' => OrderItemResource::collection($this->order_items)
        ];
    }
}
