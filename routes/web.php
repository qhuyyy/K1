<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\FoodTypeController;
Route::get('/', function () {
    return view('home');
});
Route::resource('employees',EmployeeController::class);

Route::resource('food',FoodController::class);
Route::resource('foodtypes',FoodTypeController::class);
