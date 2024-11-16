<?php

namespace App\Http\Resources;

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
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'description' => $this->description,
            'additional_info' => $this->additional_info,
            'return_and_cancellation' => $this->return_and_cancellation,
            'stock' => $this->stock,
            'brand_id' => $this->brand_id,
            'category_id' => $this->category_id,
            'vendor_id' => $this->vendor_id,
            'category_child_id' => $this->category_child_id,
            'price' => $this->price,
            'offer_price' => $this->offer_price,
            'discount' => $this->discount,
            'size' => $this->size,
            'condition' => $this->condition,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'images' => ProductImageResource::collection($this->images), // Handling related images
            'attributes' => ProductAttributeResource::collection($this->attributes) // Handling related attributes
        ];
    }
}
