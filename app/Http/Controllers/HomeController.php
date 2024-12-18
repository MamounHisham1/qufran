<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use Http;
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

        $data = Http::get('https://api.aladhan.com/v1/timingsByCity/17-12-2024?city=mecca&country')->json()['data'];

        $prayers = collect($data['timings'])->take(7);
        $prayers = $prayers->mapWithKeys(function($time, $name) use ($prayers) {
            $isNext = $prayers->first(fn($time) => \Carbon\Carbon::parse($time, 'Asia/Riyadh')->gt(now('Asia/Riyadh'))) == $time;
            return [
                $name => [
                    'time' => $time,
                    'next' => $isNext
                ]
            ];
        });
        
        return view('home', [
            'suggestedCategories' => $suggestedCategories,
            'suggestedLessons' => $suggestedLessons,
            'latestLessons' => $latestLessons,
            'famousTeachers' => $famousTeachers,
            'prayers' => $prayers,
        ]);
    }
}
