<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\PostTypes;
use DB;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function lessonIndex()
    {
        $lessons = Post::where('type', '!=', 'fatwa')->orderBy('created_at')->paginate(10);
        // dd($lessons);
        return view('lessons.index', ['lessons' => $lessons]);
    }

    public function show(Post $post)
    {
        dd($post);
    }
}
