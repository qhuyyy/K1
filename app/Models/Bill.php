<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'Date', 'Extra' ,'Total'
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'bill_products', 'Bill_ID', 'Product_ID')->withPivot('Quantity','SubTotal');
    }
    public function tables()
    {
        return $this->hasMany(Table::class, 'Bill_ID');
    }
}
