<?php

use App\Http\Controllers\courseController;
use App\Http\Controllers\homeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/home', homeController::class);

Route::resource('/courses', courseController::class);