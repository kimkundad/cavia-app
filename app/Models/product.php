<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = ['cat', 'name', 'name2', 'detail', 'image', 'status', 'stock', 'view', 'point', 'brand', 'status_2', 'type', 'credit'];

    // ความสัมพันธ์กับ Credit
    public function credits()
    {
        return $this->hasMany(Credit::class, 'product_id');
    }
}
