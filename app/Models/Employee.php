<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['Name', 'DateOfBirth', 'CICN', 'PhoneNumber', 'Position_ID'];
    public function position()
    {
        return $this->belongsTo(Position::class, 'Position_ID');
    }
}
