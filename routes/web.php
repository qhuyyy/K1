<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\FoodTypeController;
use App\Http\Controllers\ReceivedFoodController;

Route::get('/', function () {
    return view('home');
});
Route::resource('employees',EmployeeController::class);

Route::resource('food',FoodController::class);
Route::resource('foodtypes',FoodTypeController::class);

Route::resource('receivedfood',ReceivedFoodController::class);
Route::get('/search',[ReceivedFoodController::class,'search']);
Route::get('/filter',[ReceivedFoodController::class,'filterReceivedFood'])->name('filter');

Route::delete('/receivedfood/{id}/destroy', [ReceivedFoodController::class, 'destroy'])->name('receivedfood.destroy');
