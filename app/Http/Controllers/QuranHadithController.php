<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuranHadithController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Http::get('https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions.json')->json();
        dd($books);
        return view('quran-hadith.index', ['books' => $books]);
    }

    public function showSurah(int $id)
    {
        return view('quran-hadith.show-surah', ['id' => $id]);
    }

    public function showHadith(int $id)
    {
        return view('quran-hadith.show-hadith');
    }

    public function showBook(int $id)
    {
        return view('quran-hadith.show-book');
    }
}
