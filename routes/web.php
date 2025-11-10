<?php

use App\Events\assignRole;
use App\Http\Controllers\courseController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleAssignmentController;
use App\Mail\NotifyAllUsers;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware('role:admin')->group(function () {
        Route::resource('courses', CourseController::class);
        Route::get('/get-subcategories/{id}', [CourseController::class, 'getSubCategories']);
    });
    Route::get('/home', [homeController::class, 'index'])->name('home');
    Route::get('/courses/{any}', function () {
        abort(403);
    })->where('any', '.*');
});

Route::middleware(['auth', 'verified', 'role:admin'])
    ->controller(RoleAssignmentController::class)
    ->group(function () {
        Route::get('/assign-role', 'create')->name('assign.role');
        Route::post('/assign-role', 'store');
    });



Broadcast::routes();

require __DIR__.'/auth.php';

Route::get('send-mail', function () {
    $users = User::all();

    // $delay = 0;

    foreach ($users as $user) {
        Mail::to($user->email)->queue(new NotifyAllUsers);

    }

    return 'Email sent successfully!';
});
