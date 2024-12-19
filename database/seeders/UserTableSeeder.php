<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team;
use App\Models\Role;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['title' => 'Admin']);
        $userRole = Role::firstOrCreate(['title' => 'User']);
        $guestRole = Role::firstOrCreate(['title' => 'Guest']);

        $u = new User;
        $u->name = 'Ieuan';
        $u->email = 'ieuan@email.com';
        $u->password = bcrypt('password');
        $u->role_id = $userRole->id;
        $u->save();

        User::factory()
            ->count(50)
            ->hasAttached(
            Team::inRandomOrder()->take(2)->get()
            )
            ->create()
            ->each(function ($user) use ($adminRole, $userRole, $guestRole) {
                $randomRole = [$adminRole, $userRole, $guestRole][array_rand([0, 1, 2])];
                $user->role_id = $randomRole->id;
                $user->save();
            });
        }
    }