<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function availability($date)
    {
        $bookings = Booking::query()
            ->where('trip_from_id', $this->id)
            ->where('date_from', $date)
            ->orWhere(function ($query) use ($date) {
                $query->when(isset($this->back->id), function ($query) use ($date) {
                    return $query->where('trip_back_id', $this->id)
                        ->where('date_back', $date);
                });
            })
            ->withCount('passengers')
            ->get();

        $num_passengers = $bookings->sum('passengers_count');

        return $this->capacity - $num_passengers;
    }

    public function from()
    {
        return $this->belongsTo(Station::class, 'from_id');
    }

    public function to()
    {
        return $this->belongsTo(Station::class, 'to_id');
    }
}
