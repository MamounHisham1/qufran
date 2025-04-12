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
            'category_id' => fake()->randomElement(Category::all()->pluck('id')->toArray()) ?? null,
            'name' => fake('ar_SA')->sentence(),
            'description' => fake('ar_SA')->paragraph(),
            'start_at' => fake()->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'end_at' => fake()->dateTimeBetween('+1 day', '+2 months')->format('Y-m-d'),
        ];
    }
}
