<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
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
            'author_id' => fake()->randomElement(Author::all()->pluck('id')->toArray()) ?? null,  // Random Author ID or null
            'category_id' => fake()->randomElement(Category::all()->pluck('id')->toArray()) ?? null,  // Random Category ID or null
            'title' => fake()->sentence(),
            'type' => fake()->randomElement(['video', 'article', 'audio', 'photo', 'lesson']),  // Random type
            'description' => fake()->paragraph(),  // Random short description
            'body' => fake()->paragraph(5),  // Random long body text
            'image' => fake()->imageUrl(),  // Random image URL
            'video' => fake()->url(),  // Random video URL
            'audio' => fake()->url(),  // Random audio URL
            'is_published' => fake()->boolean(),  // Random boolean for publication status
        ];
    }
}
