<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function trip_from()
    {
        return $this->belongsTo(Trip::class);
    }

    public function trip_back()
    {
        return $this->belongsTo(Trip::class);
    }

    public function passengers()
    {
        return $this->belongsToMany(Passenger::class);
    }
}
