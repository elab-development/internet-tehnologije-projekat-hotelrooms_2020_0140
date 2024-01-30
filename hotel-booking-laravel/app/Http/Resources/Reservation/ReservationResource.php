<?php

namespace App\Http\Resources\Reservation;

use App\Http\Resources\Room\RoomResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = 'reservation';

    public function toArray($request)
    {
        return [
            'guest' => $this->resource->user->name,
            'room' => new RoomResource($this->resource->room),
            'check-in' => $this->resource->checkin,
            'check-out' => $this->resource->checkout,
        ];
    }
}
