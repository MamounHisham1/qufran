<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->realText(10),
            'description' => fake()->realText(),
            'image' => fake()->imageUrl(),
            'category_id' => Category::where('is_published', true)->inRandomOrder()->first()->id,
            'author_id' => Author::inRandomOrder()->first()->id,
        ];
    }
}
