<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuDish extends Model
{
    use HasFactory;
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'Menu_ID');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'Dish_ID');
    }
}
