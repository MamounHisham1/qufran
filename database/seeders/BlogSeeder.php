<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::factory(30)->create();

        Section::factory(100)->create();
    }
}
