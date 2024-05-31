<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassengerResource extends JsonResource
{
    public $booking_id;

    public function __construct($resource, $booking_id = null)
    {
        parent::__construct($resource);
        $this->booking_id = $booking_id;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birth_date' => $this->birth_date,
            'document_number' => $this->document_number,
            'place_from' => $this->booked_seats
                ->filter(fn ($seat) => $seat->booking_id == $this->booking_id && $seat->type === 'from')->first()->place ?? null,
            'place_back' => $this->booked_seats
                ->filter(fn ($seat) => $seat->booking_id == $this->booking_id && $seat->type === 'back')->first()->place ?? null,
        ];
    }
}
