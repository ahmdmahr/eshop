<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutUsResource extends JsonResource
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
            'heading' => $this->heading,
            'content' => $this->content,
            'image1' => $this->image1,
            'image2' => $this->image2,
            'image3' => $this->image3,
            'image4' => $this->image4,
            'years_of_experience' => $this->years_of_experience,
            'happy_customers' => $this->happy_customers,
            'parteners' => $this->parteners,
            'growth' => $this->growth,
            'updated_at' => $this->updated_at->toDateTimeString()
        ];
    }
}
