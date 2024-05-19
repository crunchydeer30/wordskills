<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AirportCollection;
use App\Models\Airport;

class AirportsController extends Controller
{
    public function index(): AirportCollection
    {
        $q = request('query');

        $airports = Airport::query()->when($q, function ($query) use ($q) {
            $query->where('name', 'like', "%{$q}%")
                ->orWhere('iata', 'like', "%{$q}%")
                ->orWhereHas('city', function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%");
                });
        })->get();

        $airports = new AirportCollection($airports);

        return $airports;
    }
}
