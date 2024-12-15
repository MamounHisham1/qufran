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
        $adhkar = Http::get('https://raw.githubusercontent.com/nawafalqari/azkar-api/56df51279ab6eb86dc2f6202c7de26c8948331c1/azkar.json')->json();

        $customOrder = ["bukhari", "muslim", "abudawud", "tirmidhi", "nasai", "ibnmajah", "malik", "nawawi", "dehlawi", "qudsi"];
        $books = reorderArray($books, $customOrder);

        return view('quran-hadith.index', [
            'books' => $books,
            'adhkar' => array_keys($adhkar),
        ]);
    }

    public function showSurah(int $id)
    {
        return view('quran-hadith.show-surah', ['id' => $id]);
    }

    public function showBook(string $book)
    {
        $data = Http::get("https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/ara-{$book}.json")->json();
        $metadata = $data['metadata'];
        if ($metadata['sections'][0] == "") {
            array_shift($metadata['section_details']);
            array_shift($metadata['sections']);
        }
        // dd($metadata);

        // $hadiths = $data['hadiths'];
        return view('quran-hadith.show-book', ['metadata' => $metadata, 'book' => $book]);
    }

    public function showSection($book, $section)
    {
        if ($section == 0) {
            abort(404);
        }
        $response = Http::get("https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/ara-{$book}/sections/{$section}.json");

        if (!$response->ok()) {
            return back();
        }

        $data = $response->json();

        $hadiths = $data['hadiths'];

        return view('quran-hadith.show-section', [
            'book' => $book,
            'section' => $section,
            'hadiths' => $hadiths,
        ]);
    }

    public function showAdhkar(int $id)
    {
        if($id > 7 || $id < 0) {
            abort(404);
        }

        $adhkar = Http::get('https://raw.githubusercontent.com/nawafalqari/azkar-api/56df51279ab6eb86dc2f6202c7de26c8948331c1/azkar.json')->json();
        $keys = [            
            "أذكار الصباح",
            "أذكار المساء",
            "أذكار بعد السلام من الصلاة المفروضة",
            "تسابيح",
            "أذكار النوم",
            "أذكار الاستيقاظ",
            "أدعية قرآنية",
            "أدعية الأنبياء"
        ];
        $name = $keys[$id];
        $adhkar = $adhkar[$keys[$id]];
        
        return view('quran-hadith.show-adhkar', ['adhkar' => $adhkar, 'name' => $name]);
    }
}
