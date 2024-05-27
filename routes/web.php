<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdministrativeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\GenreController;
use App\Models\Discipline;
use App\Models\Movie;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/* ----- Public Routes ----- */

// homepage
Route::view('/', 'home')->name('home');

// Movies showcase
Route::get('movies/showcase', [MovieController::class, 'showCase'])
    ->name('movies.showcase')
    ->can('viewShowCase', Movie::class);

//Discipline resource routes are protected by DisciplinePolicy on the controller
//Disciplines index and show are public ->except(['index', 'show'])
Route::resource('movies', MovieController::class);

//-------------






Route::get('courses/{course}/curriculum', [CourseController::class, 'showCurriculum'])
    ->name('courses.curriculum')
    ->can('viewCurriculum', Course::class);


/* ----- Non-Verified users ----- */
Route::middleware('auth')->group(function () {
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
});

/* ----- Verified users ----- */
Route::middleware('auth', 'verified')->group(function () {


// CHECK THIS -------- -------- -------- --------
    /* ----- Non-Verified users ----- */
    // Route::middleware('auth')->group(function () {
    //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // });
// CHECK THIS -------- -------- -------- --------


    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::delete('courses/{course}/image', [CourseController::class, 'destroyImage'])
        ->name('courses.image.destroy')
        ->can('update', Course::class);

    //Course resource routes are protected by CoursePolicy on the controller
    // The route 'show' is public (for anonymous user)
    Route::resource('courses', CourseController::class)->except(['show']);

    //Department resource routes are protected by DepartmentPolicy on the controller
    Route::resource('departments', DepartmentController::class);

    Route::get('disciplines/my', [DisciplineController::class, 'myDisciplines'])
        ->name('disciplines.my')
        ->can('viewMy', Discipline::class);

    //Discipline resource routes are protected by DisciplinePolicy on the controller
    //Disciplines index and show are public
    Route::resource('disciplines', DisciplineController::class)->except(['index', 'show']);

    Route::get('users/my', [TeacherController::class, 'myTeachers'])
        ->name('users.my')
        ->can('viewMy', Teacher::class);

    Route::delete('users/{teacher}/photo', [TeacherController::class, 'destroyPhoto'])
        ->name('users.photo.destroy')
        ->can('update', 'teacher');

    //Registered users resource routes are protected by RegisteredUserPolicy on the controller
    Route::resource('students', StudentController::class);

    Route::delete('administratives/{administrative}/photo', [AdministrativeController::class, 'destroyPhoto'])
        ->name('administratives.photo.destroy')
        ->can('update', 'administrative');

    //Employees resource routes are protected by EmployeesPolicy on the controller
    Route::resource('users', TeacherController::class);

    Route::get('students/my', [StudentController::class, 'myStudents'])
        ->name('students.my')
        ->can('viewMy', Student::class);
    Route::delete('students/{student}/photo', [StudentController::class, 'destroyPhoto'])
        ->name('students.photo.destroy')
        ->can('update', 'student');

    //Admnistrative resource routes are protected by AdministrativePolicy on the controller
    Route::resource('administratives', AdministrativeController::class);

    // Confirm (store) the cart and save disciplines registration on the database:
    Route::post('cart', [CartController::class, 'confirm'])
        ->name('cart.confirm')
        ->can('confirm-cart');
});

/* ----- OTHER PUBLIC ROUTES ----- */

// Use Cart routes should be accessible to the public */
Route::middleware('can:use-cart')->group(function () {
    // Add a discipline to the cart:
    Route::post('cart/{discipline}', [CartController::class, 'addToCart'])
        ->name('cart.add');
    // Remove a discipline from the cart:
    Route::delete('cart/{discipline}', [CartController::class, 'removeFromCart'])
        ->name('cart.remove');
    // Show the cart:
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    // Clear the cart:
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
});


//Disciplines index and show are public
Route::resource('disciplines', DisciplineController::class)->only(['index', 'show']);

require __DIR__ . '/auth.php';

// Users
Route::get('users', [UsersController::class, 'index'])->name('users.index');
Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
Route::post('users', [UsersController::class, 'store'])->name('users.store');
Route::get('users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::put('users/{user}', [UsersController::class, 'update'])->name('users.update');

// Genres
Route::get('genres', [GenreController::class, 'index'])->name('genres.index');
Route::get('genres/create', [GenreController::class, 'create'])->name('genres.create');
Route::post('genres', [GenreController::class, 'store'])->name('genres.store');
Route::get('genres/{genre}/edit', [GenreController::class, 'edit'])->name('genres.edit');
Route::put('genres/{genre}', [GenreController::class, 'update'])->name('genres.update');
Route::delete('genres/{genre}', [GenreController::class, 'destroy'])->name('genres.destroy');
Route::get('genres/{genre}', [GenreController::class, 'show'])->name('genres.show');
