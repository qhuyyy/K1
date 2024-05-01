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
}
