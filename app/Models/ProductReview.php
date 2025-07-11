<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'invoice_id',
        'user_id',
        'rating',
        'delivery_rating',
        'title',
        'image',
        'review',
        'delivery_review',
        'admin_comment',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
