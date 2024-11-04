<?php

namespace Database\Seeders;

use App\Models\Team;
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
    }
}
