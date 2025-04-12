<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('ar_SA')->name(), // Random Arabic name
            'image' => fake()->imageUrl(),   // Random image URL (no need to localize)
            'description' => fake('ar_SA')->paragraph(), // Random Arabic paragraph
        ];        
    }
}
