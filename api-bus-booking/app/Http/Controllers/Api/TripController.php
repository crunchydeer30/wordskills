<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Trips\GetManyRequest;
use App\Http\Resources\TripCollection;
use App\Http\Resources\TripResource;
use App\Models\Booking;
use App\Models\Trip;

class TripController extends Controller
{
    public function index(GetManyRequest $request)
    {
        $q = $request->validated();

        $trips_to = Trip::query()
            ->whereHas('from', function ($query) use ($q) {
                $query->where('code', $q['from']);
            })
            ->whereHas('to', function ($query) use ($q) {
                $query->where('code', $q['to']);
            })
            ->with('from.city', 'to.city')
            ->get();

        $trips_to = new TripCollection($trips_to, $q['date1']);
        $trips_to = array_filter($trips_to->toArray($request), fn ($trip) => $trip->availability($q['date1']) > $q['passengers']);

        $trips_back = isset($q['date2'])
            ? Trip::query()
            ->whereHas('from', function ($query) use ($q) {
                $query->where('code', $q['to']);
            })
            ->whereHas('to', function ($query) use ($q) {
                $query->where('code', $q['from']);
            })
            ->with('from.city', 'to.city')
            ->get()
            : [];

        $trips_back = isset($q['date2']) ? new TripCollection($trips_back, $q['date2']) : [];

        return response()->json([
            'data' => [
                'trip_to' => $trips_to,
                'trip_back' => $trips_back
            ]
        ]);
    }
}
