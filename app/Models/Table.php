<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $table = 'tables';

    public function bill()
    {
        return $this->belongsTo(Bill::class, 'Bill_ID');
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'table_dishes', 'Table_ID', 'Dish_ID')
                    ->withPivot('NumberOfDishes') // if you have additional fields in the pivot table
                    ->withTimestamps();
    }
}
