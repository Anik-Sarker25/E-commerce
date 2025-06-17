<?php

namespace App\Models;

use App\Helpers\Constant;
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
        'cancelled_at',
        'returned_at',
        'refund_at',
    ];

    public function deliveryAgent()
    {
        return $this->belongsTo(DeliveryAgent::class, 'delivery_agent_id');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
    public function getFinalDeliveryDateAttribute()
    {
        if (!$this->estimated_delivery_date || !$this->invoice) {
            return null;
        }

        $createdDate = $this->invoice->created_at
            ? $this->invoice->created_at->copy()->startOfDay()
            : now()->startOfDay();

        if ($this->estimated_delivery_date == Constant::ESTIMATED_TIME['within 24 hours']) {
            return $createdDate->addHours(24)->format('d-m-Y');
        } elseif ($this->estimated_delivery_date == Constant::ESTIMATED_TIME['1 to 3 days']) {
            return $createdDate->addDays(3)->format('d-m-Y');
        } elseif ($this->estimated_delivery_date == Constant::ESTIMATED_TIME['3 to 7 days']) {
            return $createdDate->addDays(7)->format('d-m-Y');
        }

        return '---';
    }
}
