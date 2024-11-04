<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Fixture;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'fixture_id' => Fixture::inRandomOrder()->first()->id,
            'content' => fake()->paragraph(6),
        ];
    }
}
