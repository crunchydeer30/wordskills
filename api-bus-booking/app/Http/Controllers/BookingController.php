<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bookings\BookSeatRequest;
use App\Http\Requests\Bookings\StoreRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\PassengerResource;
use App\Models\BookedSeat;
use App\Models\Booking;
use App\Models\Passenger;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
            [
                'data' => new BookingResource($booking)
            ]
        );
    }

    public function getSeats($code)
    {
        $booking = Booking::query()
            ->where('code', $code)->firstOrFail();

        $occupied_from = $booking->booked_seats->filter(fn ($seat) => $seat->type === 'from');
        $occupied_back = $booking->booked_seats->filter(fn ($seat) => $seat->type === 'back');

        return response()->json([
            'data' => [
                'occupied_from' => $occupied_from->map(fn ($seat) => ['passenger_id' => $seat->passenger_id, 'seat' => $seat->place]),
                'occupied_back' => $occupied_back->map(fn ($seat) => ['passenger_id' => $seat->passenger_id, 'seat' => $seat->place]),
            ]
        ]);
    }

    public function bookSeats(BookSeatRequest $request, $code)
    {
        $data = $request->validated();

        $booking = Booking::query()
            ->where('code', $code)->firstOrFail();

        if ($booking->user_id !== auth()->user()->id) {
            throw new AccessDeniedHttpException('Forbidden');
        }

        $passenger = $booking->passengers->find($data['passenger']);

        if (!$passenger) {
            throw new ValidationException('Пассажир не зарегистрирован в этом бронировании');
        }

        $booked_seats = [];

        if ($data['type'] === 'from') {
            $booked_seats = BookedSeat::query()
                ->whereHas('booking', function ($query) use ($booking) {
                    $query->where('trip_from_id', $booking->trip_from_id)
                        ->where('date_from', $booking->date_from)
                        ->orWhere(function ($query) use ($booking) {
                            $query->where('trip_from_id', $booking->trip_from_id)
                                ->where('date_from', $booking->date_from);
                        });
                })
                ->get();
        } else if ($data['type'] === 'back') {
            $booked_seats = BookedSeat::query()
                ->whereHas('booking', function ($query) use ($booking) {
                    $query->where('trip_from_id', $booking->trip_back_id)
                        ->where('date_from', $booking->date_back)
                        ->orWhere(function ($query) use ($booking) {
                            $query->where('trip_from_id', $booking->trip_back_id)
                                ->where('date_from', $booking->date_back);
                        });
                })
                ->get();
        }

        if ($booked_seats->pluck('place')->contains($data['seat'])) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Место занято',
                ]
            ], 422);
        }

        $booked_seat = BookedSeat::query()
            ->where('booking_id', $booking->id)
            ->where('passenger_id', $passenger->id)
            ->where('type', $data['type'])
            ->first();

        if (!$booked_seat) {
            BookedSeat::query()->create([
                'booking_id' => $booking->id,
                'passenger_id' => $passenger->id,
                'type' => $data['type'],
                'place' => $data['seat'],
            ]);
        } else {
            $booked_seat->update([
                'place' => $data['seat'],
            ]);
        }

        return response()->json([
            'data' => new PassengerResource($passenger, $booking->id)
        ]);
    }
}
