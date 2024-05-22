<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;
    protected $fillable = [
        'DishName',
        'DishType_ID', 
        'Price'
    ];
    public $timestamps = true;
    public function dish_type()
    {
        return $this->belongsTo(DishType::class, 'DishType_ID');
    }
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'dish_ingredients', 'Dish_ID', 'Ingredient_ID')->withPivot('Amount');
    }
    public function tables()
    {
        return $this->belongsToMany(Table::class, 'table_dishes', 'Dish_ID', 'Table_ID')
                    ->withPivot('NumberOfDishes')
                    ->withTimestamps();
    }
}
