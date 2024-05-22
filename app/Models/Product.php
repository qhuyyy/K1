<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function product_type()
    {
        return $this->belongsTo(ProductType::class, 'ProductType_ID');
    }
}