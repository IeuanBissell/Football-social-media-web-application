<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\League;
use App\Models\Standing;

use Illuminate\Database\Seeder;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $t = new Team;
        $t->name = 'Jelly FC';
        $t->league_id = 1;
        $t->save();
        $t->users()->attach(1);

        $t = new Team;
        $t->name = 'Fish FC';
        $t->league_id = 1;
        $t->save();

        League::all()->each(function ($league) 
        {
            Team::factory()
                ->count(10)
                ->for($league)
                ->has(Standing::factory())
                ->create();
        });
    }
}
