<?php

use App\Http\Controllers\FatwaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomeController::class)->name('dashboard');

Route::get('/lessons', [PostController::class, 'index'])->name('lessons.index');
Route::get('/lessons/{lesson:id}', [PostController::class, 'show'])->name('lessons.show');

Route::resource('/fatawa', FatwaController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
