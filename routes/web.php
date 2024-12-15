<?php

use App\Http\Controllers\ExaminationController;
use App\Http\Controllers\FatwaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\QuranHadithController;
use Illuminate\Support\Facades\Route;

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


Route::get('/lessons', [PostController::class, 'index'])->name('lessons.index');
Route::get('/lessons/{lesson:id}', [PostController::class, 'show'])->name('lessons.show');


Route::resource('/fatawa', FatwaController::class);


Route::get('/exams', [ExaminationController::class, 'index'])->middleware('auth')->name('exams.index');
Route::get('/exams/{exam:id}', [ExaminationController::class, 'show'])->middleware('auth')->name('exams.show');
Route::post('/exams/{exam:id}', [ExaminationController::class, 'store'])->middleware('auth')->name('exams.store');
Route::get('/exams/{exam:id}/completed', [ExaminationController::class, 'completed'])->middleware('auth')->name('exams.completed');


Route::get('/quran-hadith', [QuranHadithController::class, 'index'])->name(name: 'quran-hadith.index');
Route::get('/quran-hadith/surah/{id}', [QuranHadithController::class, 'showSurah'])->name('surah');

Route::get('/quran-hadith/{book}', action: [QuranHadithController::class, 'showBook'])->name('hadith.book');
Route::get('/quran-hadith/{book}/{section}', [QuranHadithController::class, 'showSection'])->name('hadith.section');
Route::get('/quran-hadith/{book}/{section}/{hadith}', [QuranHadithController::class, 'showHadith'])->name('hadith');

Route::get('/adhkar/{id}', [QuranHadithController::class, 'showAdhkar'])->name('adhkar');