<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $lessons = Post::with('author')->where('type', '!=', 'fatwa')->orderBy('created_at')->paginate(20);

        $settings = Setting::firstWhere('page', 'lessons')?->value;

        $latest = Post::whereIn('id', $settings['latest'] ?? [])->get();
        $suggested = Post::whereIn('id', $settings['suggested'] ?? [])->get();
        $mostLiked = Post::whereIn('id', $settings['most_liked'] ?? [])->get();
        $mostWatched = Post::whereIn('id', $settings['most_watched'] ?? [])->get();
        $suggestedCategories = Category::whereIn('id', $settings['suggested_categories'] ?? [])->get();

        return view('lessons.index', [
            'lessons' => $lessons,
            'latest' => $latest,
            'suggested' => $suggested,
            'mostLiked' => $mostLiked,
            'mostWatched' => $mostWatched,
            'suggestedCategories' => $suggestedCategories,
        ]);
    }

    public function show(Post $post)
    {
        dd($post);
    }
}
