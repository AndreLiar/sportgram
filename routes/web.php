<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users/{user}', function (\App\Models\User $user) {
        return view('profile.show', compact('user'));
    })->middleware('auth')->name('profile.show');
    Route::get('/feed', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/finalize', [PostController::class, 'finalize'])->name('posts.finalize');
    Route::post('/posts/regenerate-text', [PostController::class, 'regenerateFromText'])
    ->name('posts.regenerateText')
    ->middleware('auth');


});

require __DIR__.'/auth.php';
