<?php

namespace Database\Factories;

use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'flight_from_id' => Flight::inRandomOrder()->first()->id,
            'flight_back_id' => Flight::inRandomOrder()->first()->id,
            'flight_from_date' => $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'flight_back_date' => $this->faker->dateTimeBetween('+1 year', '+2 year'),
        ];
    }
}
