<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\League>
 */
class LeagueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $directions = ['North', 'South', 'East', 'West'];

        return [
            'name' => fake()->city(). ' ' . $directions[array_rand($directions)],
            'season' => fake()->numberBetween(1,3),
            'start_date' => fake()->date('Y-m-d','now'),
            'end_date' => fake()->date('Y-m-d','+1 year'),
        ];
    }
}
