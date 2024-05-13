<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Workshift>
 */
class WorkshiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 month', 'now');
        $end = new DateTime($start->format('Y-m-d H:i:s'));
        $end->modify('+8' . ' hours');

        return [
            'start' => $start,
            'end' => $end
        ];
    }
}
