<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Examination>
 */
class ExaminationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => fake()->randomElement(Category::all()->pluck('id')->toArray()) ?? null,  // Random Category ID or null
            'name' => fake()->sentence(),  // Random examination name
            'description' => fake()->paragraph(),  // Random description
            'start_at' => fake()->date(),  // Random start date (current date by default)
            'end_at' => fake()->date(),  // Random end date
        ];
    }
}
