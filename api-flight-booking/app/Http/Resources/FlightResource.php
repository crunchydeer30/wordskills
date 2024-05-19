<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'flight_id' => $this->id,
            'flight_code' => $this->flight_code,
            'from' => [
                'city' => $this->from->city,
                'airport' => $this->from->name,
                'iata' => $this->from->iata,
                'date' => date('Y-m-d', strtotime($this->departure_time)),
                'time' => date('H:i', strtotime($this->departure_time)),
            ],
            'to' => [
                'city' => $this->to->city,
                'airport' => $this->to->name,
                'iata' => $this->to->iata,
                'date' => date('Y-m-d', strtotime($this->arrival_time)),
                'time' => date('H:i', strtotime($this->arrival_time)),
            ],
            'cost' => $this->cost,
            'availability' => $this->availability
        ];
    }
}
