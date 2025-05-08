<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity',
        'size_id',
        'color_id',
        'instalment_id',
        'price',
        'total_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
