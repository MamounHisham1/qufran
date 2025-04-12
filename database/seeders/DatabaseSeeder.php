<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Author;
use App\Models\Category;
use App\Models\Examination;
use App\Models\Post;
use App\Models\Question;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Author::factory(30)->create();
        Category::factory(50)->create();
        Post::factory(200)->create();
        Examination::factory(10)->create();
        Question::factory(50)->create();
        Answer::factory(100)->create();
    }
}
