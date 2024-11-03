<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $c = new Comment;
       $c->user_id = 1;
       $c->post_id = 1;
       $c->content = 'Well played today lads';
       $c->save();
    }
}
