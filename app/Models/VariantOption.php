<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_family',
        'variant_type',
        'variant_value',
        'buy_price',
        'mrp_price',
        'discount_price',
        'sell_price',
        'stock',
    ];

    public function products() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variants() {
        return $this->belongsTo(ProductVariants::class, 'color_family');
    }

    public function invoiceItem() {
        return $this->hasMany(InvoiceItem::class, 'size_id');
    }

}
