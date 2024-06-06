<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/* ----- Public Routes ----- */

// Homepage
Route::view('/', 'home')->name('home');
Route::redirect('/', 'movies/showcase');

// Movies showcase
Route::get('movies/showcase', [MovieController::class, 'showCase'])->name('movies.showcase');


/* ----- Rotas para utilizadores autenticados e não verificados ------ */

Route::middleware('auth')->group(function () {
    Route::get('/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
});


/* ----- Rotas para utilizadores autenticados e verificados ------ */

Route::middleware('auth', 'verified')->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    /* Movies routes */
    Route::resource('movies', MovieController::class);

    Route::delete('movies/{movie}/image', [MovieController::class, 'destroyImage'])->name('movies.image.destroy');

    /* Genres routes */
    Route::resource('genres', GenreController::class)->except(['show']);

    /* Configurations routes */
    Route::resource('configurations', ConfigurationController::class)->only(['show', 'update', 'edit']);

    /* Users routes */
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'show']);
    Route::delete('users/{user}/photo', [UserController::class, 'destroyPhoto'])->name('users.photo.destroy')->can('update', 'user');

    Route::resource('customers', CustomerController::class);
    Route::get('purchases', [CustomerController::class, 'purchases'])->name('customers.purchases');

    Route::resource('theaters', TheaterController::class)->only('index', 'store', 'destroy', 'create');

    Route::resource('screenings', ScreeningController::class);


    /*//Course resource routes are protected by CoursePolicy on the controller
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

    //Disciplines index and show are public
Route::resource('disciplines', DisciplineController::class)->only(['index', 'show']);
*/

    // Confirm (store) the cart and save disciplines registration on the database:
    Route::post('cart', [CartController::class, 'confirm'])->name('cart.confirm')->can('confirm-cart');
});

/* ----- OTHER PUBLIC ROUTES ----- */

// Use Cart routes should be accessible to the public */
Route::middleware('can:use-cart')->group(function () {
    // Add a discipline to the cart:
    Route::post('cart/{discipline}', [CartController::class, 'addToCart'])->name('cart.add');
    // Remove a discipline from the cart:
    Route::delete('cart/{discipline}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    // Show the cart:
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    // Clear the cart:
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');
});

require __DIR__ . '/auth.php';

