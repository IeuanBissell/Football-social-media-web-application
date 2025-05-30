<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleTableSeeder::class);
        $this->call(LeagueTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TeamTableSeeder::class);
        $this->call(FixtureTableSeeder::class);
        $this->call(PostTableSeeder::class);
        $this->call(CommentTableSeeder::class);
        $this->call(StandingTableSeeder::class);
    }
}
