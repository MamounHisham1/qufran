<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use App\Models\Category;
use App\Models\User;
use App\PostTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FatwaController extends Controller
{
    public function index()
    {
        $fatawa = Post::where('type', 'fatwa')->paginate(10);

        $settings = Setting::firstWhere('page', 'fatawa')?->value;

        $suggestedCategories = Category::whereIn('id', $settings['suggested_categories'] ?? [])->get();
        $latest = Post::whereIn('id', $settings['latest'] ?? [])->get();
        $mostAsked = Post::whereIn('id', $settings['most_asked'] ?? [])->get();

        return view('fatawa.index', [
            'fatawa' => $fatawa,
            'suggestedCategories' => $suggestedCategories,
            'latest' => $latest,
            'mostAsked' => $mostAsked,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->is_published ? true : false);

        $fatwa = $request->validate([
            'title' => ['required', 'string', 'unique:posts,title'],
        ]);
        
        $fatwa = Post::create([
            ...$fatwa,
            'author_id' => $request->ananymos ? null : auth()->user()->id,
            'type' => PostTypes::Fatwa,
            'is_published' => $request->is_published ? true : false,
        ]);

        return back()->with('message', 'تم تقديم الفتوى');
    }

    public function show(Post $post)
    {
        return view('fatawa.show', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        Gate::authorize('fatwa-auth', $post);

        $fatwa = $request->validate([
            'title' => ['string', 'required'],
        ]);

        $post->update([
            ...$fatwa,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('fatwa-auth', $post);
        
        $post->delete();

        return redirect('/');
    }
}
