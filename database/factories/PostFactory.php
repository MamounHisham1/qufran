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
        $type = fake()->randomElement(['image', 'video', 'audio', 'article', 'fatwa']); // Randomly select type

        return [
            'author_id' => Author::query()->inRandomOrder()->value('id') ?? null, // Random Author ID or null
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? null, // Random Category ID or null
            'title' => fake()->sentence(), // Random post title
            'type' => $type, // Assign selected type
            'description' => fake()->paragraph(), // Random description
            'body' => in_array($type, ['article', 'fatwa']) ? fake()->paragraph(5) : null, // Only generate body for these types
            'image' => $type === 'image' ? fake()->imageUrl() : null, // Only generate image URL for type 'image'
            'video' => $type === 'video' ? fake()->url() : null, // Only generate video URL for type 'video'
            'audio' => $type === 'audio' ? fake()->url() : null, // Only generate audio URL for type 'audio'
            'is_published' => fake()->boolean(), // Random boolean for publication status
        ];
    }
}
