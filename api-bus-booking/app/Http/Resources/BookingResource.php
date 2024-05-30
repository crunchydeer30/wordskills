<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'cost' => ($this->trip_from->cost + $this->trip_back->cost) * count($this->passengers),
            'trips' => [
                new TripResource($this->trip_from, $this->date_from),
                new TripResource($this->trip_back, $this->date_back),
            ],
            'passengers' => $this->passengers->map(fn ($passenger) =>
            [
                'id' => $passenger->id,
                'first_name' => $passenger->first_name,
                'last_name' => $passenger->last_name,
                'birth_date' => $passenger->birth_date,
                'document_number' => $passenger->document_number,
                'place_from' => $passenger->booked_seats
                    ->filter(fn ($seat) => $seat->booking_id == $this->id && $seat->type === 'from')->first()->place ?? null,
                'place_back' => $passenger->booked_seats
                    ->filter(fn ($seat) => $seat->trip_id == $this->trip_back->id && $seat->type === 'back')->first()->place ?? null,
            ]),
        ];
    }
}
