<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $p = new Post;
        $p->user_id = 1;
        $p->fixture_id = 1;
        $p->content = 'Game today against Jelly FC';
        $p->save();

        Post::factory(50)->create();
    }
}
