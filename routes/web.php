<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FoodTypeController;
use App\Http\Controllers\ImportedFoodController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\DishTypeController;
use App\Http\Controllers\MenuController;



Route::get('/', function () {
    return view('home');
});
Route::resource('employees',EmployeeController::class);

Route::resource('foodtypes',FoodTypeController::class);

Route::resource('importedfood',ImportedFoodController::class);
Route::get('/filter-imported-food', [ImportedFoodController::class, 'filterImportedFood'])->name('filter.imported_food');
Route::get('importedfood/create/{foodtype}/{date}', [ImportedFoodController::class, 'create'])->name('importedfood.create');
Route::get('importedfood/create', [ImportedFoodController::class, 'createWithoutParams'])->name('importedfood.createWithoutParams');

Route::resource('ingredients',IngredientController::class);

Route::resource('dishtypes',DishTypeController::class);

Route::resource('dishes',DishController::class);
Route::get('/filter-dishes', [DishController::class, 'filterDish'])->name('filter.dishes');
Route::get('dishes/create', [DishController::class, 'createWithoutParams'])->name('dishes.createWithoutParams');
Route::get('dishes/create/{dishtype}', [DishController::class, 'create'])->name('dishes.create');


Route::resource('menus',MenuController::class);
Route::get('/filter-menus', [MenuController::class, 'filterMenu'])->name('filter.menus');
Route::get('menus/create', [MenuController::class, 'createWithoutParams'])->name('menus.createWithoutParams');
Route::get('menus/create/{date}', [MenuController::class, 'create'])->name('menus.create');