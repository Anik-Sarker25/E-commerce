<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cost',
        'estimated_time',
        'tracking_available',
        'status',
        'max_weight',
    ];

    public function products() {
        return $this->hasMany(Product::class, 'delivery_type');
    }
}
