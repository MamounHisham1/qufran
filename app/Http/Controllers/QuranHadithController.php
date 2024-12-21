<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Verse;
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

        $adhkar = Http::get('https://raw.githubusercontent.com/nawafalqari/azkar-api/56df51279ab6eb86dc2f6202c7de26c8948331c1/azkar.json')->json();

        $chapters = Chapter::all();

        return view('quran-hadith.index', [
            'books' => $books,
            'adhkar' => array_keys($adhkar),
            'chapters' => $chapters,
        ]);
    }

    public function showSurah(Chapter $chapter)
    {
        $verses = Verse::where('chapter_id', $chapter->id)->get();
        $tafseer = Http::get("https://quranenc.com/api/v1/translation/sura/arabic_moyassar/{$chapter->number}")->json()['result'];
        $reciters= Http::get('https://mp3quran.net/api/v3/reciters')->json()['reciters'];
        // dd($verses);

        return view('quran-hadith.show-surah', ['chapter' => $chapter, 'verses' => $verses, 'tafseer' => $tafseer]);
    }

    public function showBook(string $book)
    {
        $data = Http::get("https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/ara-{$book}.json")->json();
        $metadata = $data['metadata'];
        // dd($book == 'muslim' ? array_shift($metadata['section_details']) && array_shift($metadata['sections']) : '');
        if ($book == 'muslim' || $metadata['sections'][0] == '') {
            array_shift($metadata['section_details']);
            array_shift($metadata['sections']);
        }
        // dd($metadata);

        // $hadiths = $data['hadiths'];
        return view('quran-hadith.show-book', ['metadata' => $metadata, 'book' => $book]);
    }

    public function showSection($book, $section)
    {
        // if ($section == 0) {
        //     abort(404);
        // }
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

        $name = $keys[$id-1];

        if ($name === "أذكار الصباح") {
            $adhkar[$name] = collect($adhkar[$name])->flatMap(function ($item) {
                if (is_array($item) && !isset($item['category'])) {
                    return collect($item)->filter(fn($subItem) => isset ($subItem['category']));
                }
                return isset($item['category']) && $item['category'] !== 'stop' ? [$item] : [];
            })->values()->all();
        }

        $adhkar = $adhkar[$name];

        return view('quran-hadith.show-adhkar', ['adhkar' => $adhkar, 'name' => $name]);
    }
}
