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
use App\Http\Controllers\Admin\ConversationController as AdminConversationController;
use App\Http\Controllers\Teacher\ConversationController as TeacherConversationController;

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




#Whatsapp Routes

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/conversations', [AdminConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [AdminConversationController::class, 'show'])->name('conversations.show');
    Route::post('/conversations/{conversation}/reply', [AdminConversationController::class, 'reply'])->name('conversations.reply');
    Route::post('/conversations/{conversation}/close', [AdminConversationController::class, 'close'])->name('conversations.close');
});

// Teacher routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/conversations', [TeacherConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [TeacherConversationController::class, 'show'])->name('conversations.show');
    Route::post('/conversations/{conversation}/reply', [TeacherConversationController::class, 'reply'])->name('conversations.reply');
});

require __DIR__.'/auth.php';



















Route::get('send-mail', function () {
    $users = User::all();

    // $delay = 0;

    foreach ($users as $user) {
        Mail::to($user->email)->queue(new NotifyAllUsers);

    }

    return 'Email sent successfully!';
});
