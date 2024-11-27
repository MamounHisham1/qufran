<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Examination;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'examination_id' => fake()->randomElement(Examination::all()->pluck('id')->toArray()),  // Random Examination ID
            'correct_answer_id' => fake()->randomElement(Answer::all()->pluck('id')->toArray()),  // Random correct answer ID, or null if required
            'type' => fake()->randomElement(['pick_one_answer']),  // Random type (adjust types as needed)
            'body' => fake()->paragraph(),  // Random body of the question
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Question $question) {
            // Create an Answer for the created Question
            Answer::factory()->create([
                'question_id' => $question->id,  // Link the answer to the created question
            ]);
        });
    }
}
