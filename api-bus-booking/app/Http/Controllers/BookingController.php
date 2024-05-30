<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bookings\StoreRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Trip;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $trip_from = Trip::query()->where('id', $data['trip_from']['id'])->first();
        $trip_back = isset($data['trip_back']) ? Trip::query()->where('id', $data['trip_back']['id'])->first() : null;

        if (
            $trip_from->availability($data['trip_from']['date']) < count($data['passengers'])
            || ($trip_back && $trip_back->availability($data['trip_back']['date']) < count($data['passengers']))
        ) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Trips for selected dates are not available',
                ]
            ], 422);
        }

        $passengers = Passenger::query()
            ->insert($data['passengers']);

        $booking = Booking::query()
            ->create([
                'trip_from_id' => $data['trip_from']['id'],
                'date_from' => $data['trip_from']['date'],
                'code' => Str::random(5),
                'user_id' => request()->user()->id,
            ]);

        if (isset($data['trip_back'])) {
            $booking->trip_to_id = $data['trip_to']['id'];
            $booking->date_to = $data['trip_to']['date'];
            $booking->save();
        }

        $booking->passengers()->attach($passengers);

        return response()->json([
            'data' => [
                'code' => $booking->code
            ]
        ]);
    }

    public function show($code)
    {
        $booking = Booking::query()
            ->where('code', $code)->firstOrFail();

        return response()->json(
            new BookingResource($booking)
        );
    }
}
