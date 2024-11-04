<?php

namespace Database\Factories;

use App\Models\Team;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Standing>
 */
class StandingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $team = Team::inRandomOrder()->first();

        return [
            'games_played' =>fake()->numberBetween(1,5),
            'points' =>fake()->numberBetween(1,15),
            'wins' =>fake()->numberBetween(1,5),
            'losses' =>fake()->numberBetween(1,5),
            'draws' =>fake()->numberBetween(1,5),
            'goals_scored' =>fake()->numberBetween(1,50),
            'goals_conceded' =>fake()->numberBetween(1,50),
            'goal_difference' =>fake()->numberBetween(1,50),
            'league_id' => $team->league_id,
            'team_id' => $team->id,
        ];
    }
}
