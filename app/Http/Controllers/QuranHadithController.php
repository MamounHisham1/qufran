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
        
        $customOrder = ["bukhari", "muslim", "abudawud", "tirmidhi", "nasai", "ibnmajah", "malik", "nawawi", "dehlawi", "qudsi"];
        $books = reorderArray($books, $customOrder);

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

    public function showBook(string $slug)
    {
        $data = Http::get("https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/ara-{$slug}.json")->json();
        $metadata = $data['metadata'];
        if($metadata['sections'][0] == "") {
            array_shift($metadata['section_details']);
            array_shift($metadata['sections']);
        }
        
        // $hadiths = $data['hadiths'];
        return view('quran-hadith.show-book', ['metadata' => $metadata, 'slug' => $slug]);
    }
}
