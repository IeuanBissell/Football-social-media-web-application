<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Team;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $u = new User;
        $u->name = 'Ieuan';
        $u->email = 'ieuan@email.com';
        $u->password = 'password';
        $u->save();

        User::factory()
            ->count(50)
            ->hasAttached(
                Team::inRandomrder()->take(2)->get()
            )
            ->create();
    }
}
