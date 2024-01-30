<?php

namespace App\Http\Resources\Room;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'room';

    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'number' => $this->resource->number,
            'features' => $this->resource->features,
            'price per night' => $this->resource->price,
            'hotel' => $this->resource->hotel->name,
        ];
    }
}
