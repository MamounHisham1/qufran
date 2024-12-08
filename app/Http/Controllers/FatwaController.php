<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use App\PostTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FatwaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fatawa = Post::where('type', 'fatwa')->paginate(10);

        $settings = Setting::firstWhere('page', 'fatawa')?->value;

        $latest = Post::whereIn('id', $settings['latest'] ?? []);
        $mostAsked = Post::whereIn('id', $settings['most_asked'] ?? []);

        return view('fatawa.index', [
            'fatawa' => $fatawa,
            'latest' => $latest,
            'mostAsked' => $mostAsked,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fatawa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fatwa = $request->validate([
            'title' => ['string', 'required'],
        ]);
        
        Post::create([
            ...$fatwa,
            'user_id' => auth()->user()->id,
            'type' => PostTypes::Fatwa,
            'is_published' => true,
        ]);

        return back()->with('message', 'تم تقديم الفتوى');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        Gate::authorize('fatwa-auth', $post);

        return view('fatwa.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('fatwa-auth', $post);

        return view('fatwa.edit', $post);
    }

    /**
     * Update the specified resource in storage.
     */
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
