<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $settings = Setting::firstWhere('page', 'home')?->value;

        $suggestedCategories = Category::findByMap($settings['suggested_categories']);
        $suggestedLessons = Post::findByMap($settings['suggested_lessons']);
        $latestLessons = Post::findByMap($settings['latest_lessons']);
        $famousTeachers = Author::findByMap($settings['famous_teachers']);

        return view('home', [
            'suggestedCategories' => $suggestedCategories,
            'suggestedLessons' => $suggestedLessons,
            'latestLessons' => $latestLessons,
            'famousTeachers' => $famousTeachers,
        ]);
    }
}
