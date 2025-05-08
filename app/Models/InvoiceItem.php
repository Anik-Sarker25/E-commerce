<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'color_id',
        'size_id',
        'instalment_id',
        'product_name',
        'price',
        'total_price',
        'quantity',
    ];

    public function products() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function invoices() {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function color()
    {
        return $this->belongsTo(ProductVariants::class, 'color_id');
    }
    public function size()
    {
        return $this->belongsTo(VariantOption::class, 'size_id');
    }

}
