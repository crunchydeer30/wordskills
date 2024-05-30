<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function bookings()
    {
        return $this->belongsToMany(Booking::class);
    }

    public function booked_seats()
    {
        return $this->hasMany(BookedSeat::class, 'passenger_id');
    }
}
