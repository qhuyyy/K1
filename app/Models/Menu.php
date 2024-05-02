<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['Date', 'NumberOfTotalPortions'];
    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'menu_dishes', 'Menu_ID', 'Dish_ID')->withPivot('NumberOfPortions');
    }
}
