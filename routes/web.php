<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FoodTypeController;
use App\Http\Controllers\ReceivedFoodController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\DishTypeController;

Route::get('/', function () {
    return view('home');
});
Route::resource('employees',EmployeeController::class);

Route::resource('foodtypes',FoodTypeController::class);

Route::resource('receivedfood',ReceivedFoodController::class);
Route::get('/filter-received-foods', [ReceivedFoodController::class, 'filterReceivedFood'])->name('filter.received_foods');

Route::delete('/receivedfood/{id}/destroy', [ReceivedFoodController::class, 'destroy'])->name('receivedfood.destroy');

Route::get('/get-food-type-name/{foodTypeID}', [FoodTypeController::class, 'getFoodTypeName']);
Route::get('receivedfood/create/{foodtype}/{date}', [ReceivedFoodController::class, 'create'])->name('receivedfood.create');
Route::get('receivedfood/create', [ReceivedFoodController::class, 'createWithoutParams'])->name('receivedfood.createWithoutParams');

Route::resource('ingredients',IngredientController::class);

Route::resource('dishes',DishController::class);
Route::get('/filter-dishes', [DishController::class, 'filterDish'])->name('filter.dishes');
Route::get('dishes/create', [DishController::class, 'createWithoutParams'])->name('dishes.createWithoutParams');
Route::get('dishes/create/{dishtype}', [DishController::class, 'create'])->name('dishes.create');

Route::resource('dishtypes',DishTypeController::class);