<?php

namespace Database\Seeders;

use App\Models\Fixture;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FixtureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $f = new Fixture;
      $f->league_id = 1;
      $f->home_team_id = 1;
      $f->away_team_id = 2;
      $f->match_date = Carbon::createFromFormat('Y-m-d H:i:s', '2024-11-10 15:00:00');
      $f->location = 'Sketty Lane';
      $f->home_team_score = 3;
      $f->away_team_score = 0; 
      $f->save();
    }
}
