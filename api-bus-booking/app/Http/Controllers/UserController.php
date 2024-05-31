<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingCollection;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return new UserResource($user);
    }

    public function bookings()
    {
        $user = auth()->user();

        return new BookingCollection($user->bookings);
    }
}
