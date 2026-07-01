<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Story;

Route::get('/', function () {
    $stories = Story::latest()->get();
    return view('home', compact('stories'));
});

Route::get('/kwento/{story:slug}', function (Story $story) {
    return view('story', compact('story'));
})->name('story.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Story Routes
    Route::get('/admin/stories', [\App\Http\Controllers\Admin\StoryController::class, 'create'])->name('admin.stories.create');
    Route::post('/admin/stories', [\App\Http\Controllers\Admin\StoryController::class, 'store'])->name('admin.stories.store');
});

require __DIR__.'/auth.php';

