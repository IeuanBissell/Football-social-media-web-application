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
        $userRole = Role::where('title', 'User')->first();
        $adminRole = Role::where('title','Admin')->first();

        $u = new User;
        $u->name = 'Ieuan';
        $u->email = 'ieuan@email.com';
        $u->password = bcrypt('password');
        $u->role_id = $adminRole->id;
        $u->save();

        User::factory()
            ->count(50)
            ->hasAttached(
            Team::inRandomOrder()->take(2)->get()
            )
            ->create()
            ->each(function ($user) use ($adminRole, $userRole) {
                $user->role_id = $userRole->id;
                $user->save();
            });
        }
    }