<?php

namespace Database\Factories;

use App\Models\League;
use App\Models\Team;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fixture>
 */
class FixtureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'league_id' => League::inRandomOrder()->first()->id,
            'home_team_id' => Team::inRandomOrder()->first()->id,
            'away_team_id' => Team::inRandomOrder()->first()->id,
            'match_date' => fake()->dateTimeBetween('-1 month','+1 month')->format('Y-m-d H:i:s'),
            'location' => fake()->address(),
            'home_team_score' => fake()->numberBetween(1,10),
            'away_team_Score' => fake()->numberBetween(1,10),
        ];
    }
}
