<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Chapter;
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

        // $quran = Http::get('https://api.quran.com/api/v4/chapters')->json()['chapters'];
        $chapters = Chapter::all()->take(20);


        $books = Http::get('https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions.json')->json();
        $customOrder = ["bukhari", "muslim", "abudawud", "tirmidhi", "nasai", "ibnmajah", "malik", "nawawi", "dehlawi", "qudsi"];
        $books = reorderArray($books, $customOrder);
        $books = collect($books)->take(4)->toArray();

        $adhkar = Http::get('https://raw.githubusercontent.com/nawafalqari/azkar-api/56df51279ab6eb86dc2f6202c7de26c8948331c1/azkar.json')->json();
        $adhkar = collect($adhkar)->take(4)->toArray();

        $suggestedCategories = Category::whereIn('id', $settings['suggested_categories'] ?? [])->get();
        $suggestedLessons = Post::whereIn('id', $settings['suggested_lessons'] ?? [])->get();
        $latestLessons = Post::whereIn('id', $settings['latest_lessons'] ?? [])->get();
        $famousTeachers = Author::whereIn('id', $settings['famous_teachers'] ?? [])->get();
        $fatawa = Post::where('type', 'fatwa')->where('body', '!=', null)->inRandomOrder()->take(3)->get();

        $data = Http::get('https://api.aladhan.com/v1/timingsByCity/17-12-2024?city=mecca&country')->json()['data'];

        $prayers = collect($data['timings'])->take(7);
        $prayers = $prayers->mapWithKeys(function($time, $name) use ($prayers) {
            $isNext = $prayers->first(fn($time) => \Carbon\Carbon::parse($time, 'Asia/Riyadh')->gt(now('Asia/Riyadh'))) == $time;
            return [
                $name => [
                    'time' => $time,
                    'next' => $isNext ?? 'Fajr'
                ]
            ];
        });
        
        return view('home', [
            'suggestedCategories' => $suggestedCategories,
            'suggestedLessons' => $suggestedLessons,
            'latestLessons' => $latestLessons,
            'famousTeachers' => $famousTeachers,
            'prayers' => $prayers,
            'fatawa' => $fatawa,
            'chapters' => $chapters,
            'books' => $books,
            'adhkar' => array_keys($adhkar),
        ]);
    }
}
