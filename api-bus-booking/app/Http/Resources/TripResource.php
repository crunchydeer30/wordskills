<?php

namespace App\Http\Resources;

use App\Models\BookedSeat;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    protected $date;

    public function __construct($resource, $date)
    {
        parent::__construct($resource);
        $this->date = $date;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $bookings = Booking::query()
            ->where('trip_from_id', $this->id)
            ->where('date_from', $this->date)
            ->orWhere(function ($query) {
                $query->when(isset($this->back->id), function ($query) {
                    return $query->where('trip_back_id', $this->id)
                        ->where('date_back', $this->date);
                });
            })
            ->withCount('passengers')
            ->get();

        $num_passengers = $bookings->sum('passengers_count');

        return [
            'trip_id' => $this->id,
            'trip_code' => $this->trip_code,
            'from' => [
                'city' => $this->from->city->name,
                'station' => $this->from->name,
                'code' => $this->from->code,
                'date' => $this->date,
                'time' => $this->departure,
            ],
            'to' => [
                'city' => $this->to->city->name,
                'station' => $this->to->name,
                'code' => $this->to->code,
                'date' => $this->date,
                'time' => $this->arrival
            ],
            'cost' => $this->cost,
            'availability' => $this->availability($this->date)
        ];
    }
}
