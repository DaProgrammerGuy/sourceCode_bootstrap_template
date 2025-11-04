<?php

use App\Http\Controllers\courseController;
use App\Http\Controllers\homeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [homeController::class, 'index'])->name('home');;

Route::resource('/courses', courseController::class);