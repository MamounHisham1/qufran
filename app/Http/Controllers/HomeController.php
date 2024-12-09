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

        $suggestedCategories = Category::whereIn('id', $settings['suggested_categories'] ?? [])->get();
        $suggestedLessons = Post::whereIn('id', $settings['suggested_lessons'] ?? [])->get();
        $latestLessons = Post::whereIn('id', $settings['latest_lessons'] ?? [])->get();
        $famousTeachers = Author::whereIn('id', $settings['famous_teachers'] ?? [])->get();
        
        return view('home', [
            'suggestedCategories' => $suggestedCategories,
            'suggestedLessons' => $suggestedLessons,
            'latestLessons' => $latestLessons,
            'famousTeachers' => $famousTeachers,
        ]);
    }
}
