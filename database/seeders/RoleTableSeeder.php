<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['title' => 'Admin']);
        Role::firstOrCreate(['title' => 'User']);
        Role::firstOrCreate(['title' => 'Guest']);
    }
}
