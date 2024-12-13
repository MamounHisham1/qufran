<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuranHadithController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('quran-hadith.index');
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
