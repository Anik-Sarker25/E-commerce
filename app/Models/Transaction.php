<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_id',
        'payment_method',
        'transaction_type',
        'amount',
        'currency',
        'transaction_status',
        'transaction_id',
        'gateway_response',
        'remarks',
        'ip_address',
    ];

    // relation with user
    public function user() {
        return $this->belongsTo(User::class);
    }
}
