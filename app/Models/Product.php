<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'childcategory_id',
        'brand_id',
        'delivery_type',
        'name',
        'slug',
        'buy_price',
        'mrp_price',
        'discount_price',
        'sell_price',
        'thumbnail',
        'description',
        'return',
        'warranty',
        'deals_time',
        'product_type',
        'unit',
        'keywords',
        'item_code',
        'status',
        'has_variants',
    ];

    public function featuredImages(){
        return $this->hasMany(ProductFeaturedImage::class, 'product_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory(){
        return $this->belongsTo(Subcategory::class,'subcategory_id');
    }

    public function childcategory(){
        return $this->belongsTo(Childcategory::class, 'childcategory_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function deliveryType(){
        return $this->belongsTo(DeliveryOption::class, 'delivery_type');
    }

    public function invoiceItem() {
        return $this->hasMany(InvoiceItem::class, 'product_id');
    }

    public function variants() {
        return $this->hasMany(ProductVariants::class, 'product_id');
    }

    public function variantOptions() {
        return $this->hasMany(VariantOption::class, 'product_id');
    }

}
