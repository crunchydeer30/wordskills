<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'flight_code',
        'from_airport_id',
        'to_airport_id',
        'departure_date',
        'arrival_date',
        'cost',
        'availablity'
    ];

    public function from()
    {
        return $this->belongsTo(Airport::class, 'from_airport_id');
    }

    public function to()
    {
        return $this->belongsTo(Airport::class, 'to_airport_id');
    }
}
