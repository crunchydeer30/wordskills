<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;
use App\Models\Airport;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departure = $this->faker->dateTimeBetween('now', '+1 month');
        $arrival = new DateTime($departure->format('Y-m-d H:i:s'));
        $arrival->modify('+' . $this->faker->numberBetween(1, 20) . ' hours');

        $from = $to = Airport::all()->random();
        while ($from->id === $to->id) {
            $to = Airport::all()->random();
        }

        return [
            'flight_code' => $this->faker->randomNumber(5),
            'from_airport_id' => $from,
            'to_airport_id' => $to,
            'departure_time' => $departure,
            'arrival_time' => $arrival,
            'cost' => $this->faker->numberBetween(10000, 20000),
            'availability' => $this->faker->numberBetween(100, 200),
        ];
    }
}
