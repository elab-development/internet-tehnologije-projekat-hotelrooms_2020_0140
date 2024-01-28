<?php

namespace App\Http\Resources\Hotel;

use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'hotel';

    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'city' => $this->resource->city,
            'address' => $this->resource->address,
            'rating' => $this->resource->rating,
            'description' => $this->resource->description,
        ];
    }
}
