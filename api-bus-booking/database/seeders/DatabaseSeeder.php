<?php

namespace Database\Seeders;

use App\Models\BookedSeat;
use App\Models\Booking;
use App\Models\City;
use App\Models\Passenger;
use App\Models\Station;
use App\Models\Trip;
use App\Models\User;
use Database\Factories\BookingFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            "first_name" => "Ivan",
            "last_name" => "Ivanov",
            "document_number" => "1234567890",
            "phone" => "123",
            "password" => "P@ssw0rd"
        ]);

        City::factory()->createMany([
            ['name' => 'Иркутск'],
            ['name' => 'Братск'],
        ]);

        Station::factory()->createMany([
            [
                'name' => 'Иркутск',
                'city_id' => 1,
                'code' => 395
            ],
            [
                'name' => 'Братск',
                'city_id' => 2,
                'code' => 3952
            ],
        ]);

        Trip::factory()->createMany([
            [
                'trip_code' => 'FP1200',
                'from_id' => 1,
                'to_id' => 2,
                'departure' => '12:00',
                'arrival' => '13:35',
                'cost' => 9500,
                'capacity' => 160
            ],
            [
                'trip_code' => 'FP1201',
                'from_id' => 1,
                'to_id' => 2,
                'departure' => '08:35',
                'arrival' => '10:05',
                'cost' => 10500,
                'capacity' => 160
            ],
            [
                'trip_code' => 'FP2100',
                'from_id' => 2,
                'to_id' => 1,
                'departure' => '08:35',
                'arrival' => '10:05',
                'cost' => 10500,
                'capacity' => 160
            ],
            [
                'trip_code' => 'FP2101',
                'from_id' => 2,
                'to_id' => 1,
                'departure' => '12:00',
                'arrival' => '13:35',
                'cost' => 12500,
                'capacity' => 160
            ],
        ]);

        $passengers = Passenger::factory()->createMany([
            [
                'first_name' => 'Ivan',
                'last_name' => 'Ivanov',
                'document_number' => '1111111111',
                'birth_date' => '1990-02-20'
            ],
            [
                'first_name' => 'Ivan',
                'last_name' => 'Petrov',
                'document_number' => '2222222222',
                'birth_date' => '1980-03-20'
            ],
        ]);

        $booking = Booking::factory()->create(
            [
                'trip_from_id' => 1,
                'trip_back_id' => 2,
                'date_from' => '2024-05-29',
                'date_back' => '2024-05-30',
                'code' => 'QSASE',
                'user_id' => 1
            ]
        );

        $booking->passengers()->attach($passengers);

        $booked_seats = BookedSeat::factory()->createMany([
            [
                'place' => '7B',
                'booking_id' => $booking->id,
                'passenger_id' => $passengers[0]->id
            ]
        ]);
    }
}
