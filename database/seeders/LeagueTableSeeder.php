<?php

namespace Database\Seeders;

use App\Models\League;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LeagueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lg = new League;
        $lg->name = 'Swansea University';
        $lg->season = 1;
        $lg->start_date = Carbon::createFromFormat('Y-m-d', '2024-11-10');
        $lg->end_date = Carbon::createFromFormat('Y-m-d','2025-6-5');
        $lg->save();

        League::factory(5)->create();
    }
}
