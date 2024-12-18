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
        $fatawa = Post::where('type', 'fatwa')->where('body', '!=', null)->where('is_published', true)->paginate(perPage: 5);

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
        
        $number = Post::where('type', 'fatwa')->latest()->limit(1)->get()[0]->fatwa_number;

        $fatwa = Post::create([
            ...$fatwa,
            'type' => PostTypes::Fatwa,
            'user_id' => auth()->user()->id,
            'fatwa_number' => $number + 1 ?? 1,
            'is_published' => $request->is_published ? true : false,
        ]);

        return back()->with('message', "تم رفع الفتوى برقم {$fatwa->fatwa_number}");
    }

    public function show(Post $fatwa)
    {
        // dd($fatwa);
        return view('fatawa.show', ['fatwa' => $fatwa]);
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
