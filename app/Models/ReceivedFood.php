<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivedFood extends Model
{
    use HasFactory;
    public function food_type()
    {
        return $this->belongsTo(FoodType::class, 'FoodType_ID');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'Unit_ID');
    }
}
