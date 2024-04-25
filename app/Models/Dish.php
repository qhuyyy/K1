<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    public function ingredient1()
    {
        return $this->belongsTo(Ingredient::class, 'Ingredient1_ID');
    }
    public function ingredient2()
    {
        return $this->belongsTo(Ingredient::class, 'Ingredient2_ID');
    }
    public function ingredient3()
    {
        return $this->belongsTo(Ingredient::class, 'Ingredient3_ID');
    }
    public function ingredient4()
    {
        return $this->belongsTo(Ingredient::class, 'Ingredient4_ID');
    }
    public function ingredient5()
    {
        return $this->belongsTo(Ingredient::class, 'Ingredient5_ID');
    }
    public function dish_type()
    {
        return $this->belongsTo(DishType::class, 'DishType_ID');
    }
}
