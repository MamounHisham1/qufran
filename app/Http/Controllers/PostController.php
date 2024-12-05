<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use App\PostTypes;
use DB;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $lessons = Post::where('type', '!=', 'fatwa')->orderBy('created_at')->paginate(10);

        $settings = Setting::firstWhere('page', 'lessons')?->value;

        $latest = Post::findByMap($settings['latest']);
        $suggested = Post::findByMap($settings['suggested']);
        $mostLiked = Post::findByMap($settings['most_liked']);
        $mostWatched = Post::findByMap($settings['most_watched']);
        $suggestedCategories = Post::findByMap($settings['suggested_categories']);
        
        return view('lessons.index', [
            'lessons' => $lessons,
            'latest' => $latest,
            'suggested' => $suggested,
            'most_liked' => $mostLiked,
            'most_watched' => $mostWatched,
            'suggested_categories' => $suggestedCategories,
        ]);
    }

    public function show(Post $post)
    {
        dd($post);
    }
}
