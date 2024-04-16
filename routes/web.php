<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EmployeeController;
Route::get('/', function () {
    return view('home');
});
Route::resource('employees',EmployeeController::class);

