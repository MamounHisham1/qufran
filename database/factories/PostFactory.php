<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Category;
use App\Models\User;
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
            // 'user_id' => $type['fatwa'] ? User::query()->inRandomOrder()->value('id') : null, // Random user ID if it is a Fatwa
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? null, // Random Category ID or null
            'title' => fake('ar_SA')->sentence(), // Random post title
            'type' => $type, // Assign selected type
            'description' => fake('ar_SA')->paragraph(), // Random description
            'body' => in_array($type, ['article', 'fatwa']) ? fake('ar_SA')->paragraph(5) : null, // Only generate body for these types
            'image' => $type === 'image' ? fake()->imageUrl() : null, // Only generate image URL for type 'image'
            'video' => $type === 'video' ? fake()->url() : null, // Only generate video URL for type 'video'
            'audio' => $type === 'audio' ? fake()->url() : null, // Only generate audio URL for type 'audio'
            'is_published' => fake()->boolean(), // Random boolean for publication status
        ];
    }
}
