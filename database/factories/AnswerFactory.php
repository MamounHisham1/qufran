<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_id' => fake()->randomElement(Question::all()->pluck('id')->toArray()),  // Random Question ID
            'body' => fake()->sentence(),  // Random body for the answer (you can adjust to paragraph or other types)
        ];
    }
}
