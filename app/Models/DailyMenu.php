<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyMenu extends Model
{
    use HasFactory;
    public function dish1()
    {
        return $this->belongsTo(Dish::class, 'Dish1_ID');
    }
    public function dish2()
    {
        return $this->belongsTo(Dish::class, 'Dish2_ID');
    }
    public function dish3()
    {
        return $this->belongsTo(Dish::class, 'Dish3_ID');
    }
    public function dish4()
    {
        return $this->belongsTo(Dish::class, 'Dish4_ID');
    }
    public function dish5()
    {
        return $this->belongsTo(Dish::class, 'Dish5_ID');
    }
    public function dish6()
    {
        return $this->belongsTo(Dish::class, 'Dish6_ID');
    }
    public function dish7()
    {
        return $this->belongsTo(Dish::class, 'Dish7_ID');
    }
    public function dish8()
    {
        return $this->belongsTo(Dish::class, 'Dish8_ID');
    }
    public function dish9()
    {
        return $this->belongsTo(Dish::class, 'Dish9_ID');
    }
    public function dish10()
    {
        return $this->belongsTo(Dish::class, 'Dish10_ID');
    }
}
