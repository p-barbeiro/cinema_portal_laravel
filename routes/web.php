<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Support\Facades\Route;

 Route::get('/', function () {
     return view('welcome');
 })->name('home');
