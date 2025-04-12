<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        Suggestion::create(['body' => $request->body, 'user_id' => auth()->user()?->id]);

        return back()->with('message', 'تم رفع الاقتراح بنجاح');
    }
}
