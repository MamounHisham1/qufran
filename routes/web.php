<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\FatwaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuranHadithController;
use Illuminate\Support\Facades\Route;
use App\Models\Chapter;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/', HomeController::class)->name('dashboard');


Route::get('/categories/{category:id}', CategoryController::class)->name('category');


Route::get('/lessons', [PostController::class, 'index'])->name('lessons.index');
Route::get('/lessons/{lesson:id}', [PostController::class, 'show'])->name('lessons.show');


Route::get('/fatawa', [FatwaController::class, 'index'])->name('fatawa.index');
Route::get('/fatawa/{fatwa:id}', [FatwaController::class, 'show'])->name('fatawa.show');
Route::post('/fatawa', [FatwaController::class, 'store'])->middleware('auth')->name('fatawa.store');
Route::put('/fatawa/{id}', [FatwaController::class, 'update'])->middleware('auth')->name('fatawa.update');
Route::delete('/fatawa/{id}', [FatwaController::class, 'destroy'])->middleware('auth')->name('fatawa.destroy');


Route::get('/exams', [ExaminationController::class, 'index'])->middleware('auth')->name('exams.index');
Route::get('/exams/{exam:id}', [ExaminationController::class, 'show'])->middleware('auth')->name('exams.show');
Route::post('/exams/{exam:id}', [ExaminationController::class, 'store'])->middleware('auth')->name('exams.store');
Route::get('/exams/{exam:id}/completed', [ExaminationController::class, 'completed'])->middleware('auth')->name('exams.completed');


Route::get('/quran-hadith', [QuranHadithController::class, 'index'])->name(name: 'quran-hadith.index');
Route::get('/quran-hadith/surah/{chapter}', [QuranHadithController::class, 'showSurah'])->name('surah');

Route::get('/quran-hadith/{book}', action: [QuranHadithController::class, 'showBook'])->name('hadith.book');
Route::get('/quran-hadith/{book}/{section}', [QuranHadithController::class, 'showSection'])->name('hadith.section');
Route::get('/quran-hadith/{book}/{section}/{hadith}', [QuranHadithController::class, 'showHadith'])->name('hadith');

Route::get('/adhkar/{id}', [QuranHadithController::class, 'showAdhkar'])->name('adhkar');



// Route::get('/save-chapters', function () {
//     $chapters = Http::get('https://api.quran.com/api/v4/chapters')->json()['chapters'];

//     foreach ($chapters as $chapter) {
//         Chapter::updateOrCreate([
//             'number' => $chapter['id'],
//         ], [
//             'name' => $chapter['name_arabic'],
//             'bismillah' => $chapter['bismillah_pre'],
//             'place' => $chapter['revelation_place'],
//             'order_number' => $chapter['revelation_order'],
//             'verses' => $chapter['verses_count'],
//             'page_start' => $chapter['pages'][0],
//             'page_end' => $chapter['pages'][1],
//         ]);
//     }

//     dd('done');
// });

// Route::get('/save-ayat', function () {
//     $chapters = Chapter::all();

//     foreach ($chapters as $chapter) {
//         $ayat = Http::get("https://api.quran.com/api/v4/quran/verses/uthmani?chapter_number={$chapter->number}")->json();

//         foreach ($ayat['verses'] as $verse) {
//             // Use updateOrCreate to either update the existing verse or create a new one
//             $chapter->verses()->updateOrCreate(
//                 ['number' => $verse['id']], // Search for an existing verse by its number
//                 ['text' => $verse['text_uthmani']] // Update or set the text if it's a new verse
//             );
//         }
//     }

//     dd('done');
// });