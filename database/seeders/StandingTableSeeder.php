<?php

namespace Database\Seeders;

use App\Models\Standing;
use Illuminate\Database\Seeder;

class StandingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $s = new Standing;
        $s->games_played = 1;
        $s->points = 3;
        $s->wins = 1;
        $s->losses = 0;
        $s->draws = 0;
        $s->goals_scored = 3;
        $s->goals_conceded = 0;
        $s->goal_difference = 3;
        $s->league_id = 1;
        $team_id = 1;
        $s->save();

        $s = new Standing;
        $s->games_played = 1;
        $s->points = 0;
        $s->wins = 0;
        $s->losses = 1;
        $s->draws = 0;
        $s->goals_scored = 0;
        $s->goals_conceded = 3;
        $s->goal_difference = -3;
        $s->league_id = 1;
        $team_id = 2;
        $s->save();
    }
}
