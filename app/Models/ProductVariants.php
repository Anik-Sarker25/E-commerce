<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariants extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'color_name',
        'color_code',
        'size',
        'storage_capacity',
        'buy_price',
        'mrp_price',
        'discount_price',
        'sell_price',
        'stock_quantity',
        'color_image',
    ];
}
