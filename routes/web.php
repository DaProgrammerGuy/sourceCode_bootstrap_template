<?php

use App\Http\Controllers\courseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/home', function () {
//     return view('home');
// })->name('home');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/courses', courseController::class);

    Route::get('/get-subcategories/{id}', [courseController::class, 'getSubcategories']);

    Route::get('/home', function () {
        return view('home');
    })->name('home');

});

require __DIR__.'/auth.php';
