<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlightsRequest;
use App\Http\Resources\FlightCollection;
use App\Models\Flight;

class FlightsController extends Controller
{
    public function index(FlightsRequest $request)
    {
        $q = $request->validated();

        $flights_to = Flight::query()
            ->whereHas('from', function ($query) use ($q) {
                return $query->where('iata', $q['from']);
            })
            ->whereHas('to', function ($query) use ($q) {
                return $query->where('iata', $q['to']);
            })
            ->whereDate('departure_time', $q['date1'])
            ->with('from.city', 'to.city')
            ->get();

        $flights_back = isset($q['date2']) ? Flight::query()
            ->whereHas('from', function ($query) use ($q) {
                return $query->where('iata', $q['to']);
            })
            ->whereHas('to', function ($query) use ($q) {
                return $query->where('iata', $q['from']);
            })
            ->whereDate('departure_time', $q['date2'])
            ->with('from.city', 'to.city')
            ->get() : [];

        $flights_to = new FlightCollection($flights_to);
        $flights_back = new FlightCollection($flights_back);

        return response()->json([
            'data' => [
                'flights_to' => $flights_to,
                'flights_back' => $flights_back
            ]
        ]);
    }
}
