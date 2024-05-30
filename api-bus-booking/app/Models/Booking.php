<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'trip_from_id',
        'trip_back_id',
        'date_from',
        'date_back',
        'code',
        'passengers',
        'user_id',
    ];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
