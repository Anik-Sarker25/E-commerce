<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentTracking extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'tracking_number',
        'delivery_agent_id',
        'status',
        'estimated_delivery_date',
        'confirmed_at',
        'processed_at',
        'shipped_at',
        'delivered_at',
        'canceled_at',
        'returned_at',
        'refund_at',
    ];
}
