<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address_id',
        'tracking_code',
        'price',
        'discount',
        'shipping_cost',
        'total_price',
        'payment_method',
        'payment_status',
        'delivery_type',
        'estimated_delivery_date',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function invoiceItem() {
        return $this->hasMany(InvoiceItem::class);
    }

    public function deliveryType(){
        return $this->belongsTo(DeliveryOption::class, 'delivery_type');
    }

}
