<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;

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
    Route::resource('users', UserController::class);
    Route::delete('users/{user}/photo', [UserController::class, 'destroyPhoto'])->name('users.photo.destroy')->can('update', 'user');

    Route::resource('customers', CustomerController::class);
    Route::get('purchases', [CustomerController::class, 'purchases'])->name('customers.purchases');

    Route::resource('theaters', TheaterController::class);

    Route::resource('screenings', ScreeningController::class);

    Route::get('purchases/{customer}', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('purchases/{purchase}/receipt', [PurchaseController::class, 'showReceipt'])->name('purchases.show');
    Route::get('purchases/{purchase}/download', [PurchaseController::class, 'downloadReceipt'])->name('purchases.download');
    Route::get('purchases/{purchase}/tickets', [TicketController::class, 'index'])->name('tickets.index');

    Route::get('tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('tickets/{ticket}/invalidate', [TicketController::class, 'invalidateTicket'])->name('tickets.invalidate');
    Route::get('tickets/{ticket}/download', [TicketController::class, 'download'])->name('tickets.download');

    /* Statistics routes */
    Route::get('/statistics/overall', [StatisticsController::class, 'overall'])->name('statistics.overall');
    Route::get('/statistics/theater', [StatisticsController::class, 'theater'])->name('statistics.theater');
    Route::get('/statistics/movie', [StatisticsController::class, 'movie'])->name('statistics.movie');
    Route::get('/statistics/screening', [StatisticsController::class, 'screening'])->name('statistics.screening');
    Route::get('/statistics/customer', [StatisticsController::class, 'customer'])->name('statistics.customer');

    /* Export routes */
    Route::get('statistics/export/overall', [ExportController::class, 'exportOverallStatistics'])->name('statistics.export.overall');
    Route::get('export/theater-statistics', [ExportController::class, 'exportTheaterStatistics'])->name('export.theater.statistics');
    Route::get('export/movie-statistics', [ExportController::class, 'exportMoviesStatistics'])->name('export.movie.statistics');
    Route::get('export/screening-statistics', [ExportController::class, 'exportScreeningsStatistics'])->name('export.screening.statistics');
    Route::get('export/customer-statistics', [ExportController::class, 'exportCustomerStatistics'])->name('export.customer.statistics');

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
});

/* ----- CART ROUTES ----- */


// Use Cart routes should be accessible to the public */
Route::middleware('can:use-cart')->group(function () {
    // Add a screening to the cart:
    Route::post('cart/{screening}', [CartController::class, 'addToCart'])->name('cart.add');
    // Remove a screening from the cart:
    Route::delete('cart/{screening}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    // Show the cart:
    Route::get('cart', [CartController::class, 'show'])->name('cart.show');
    // Payment
    Route::get('cart/payment', [CartController::class, 'payment'])->name('cart.payment');
    // Confirm cart
    Route::post('cart', [CartController::class, 'confirm'])->name('cart.confirm')->can('confirm-cart');
    // Clear the cart:
    Route::delete('cart', [CartController::class, 'destroy'])->name('cart.destroy');

});

require __DIR__ . '/auth.php';
