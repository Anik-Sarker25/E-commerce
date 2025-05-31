<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAgent extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'vehicle_number',
        'image',
        'nid_number',
        'blood_group',
        'address',
        'marital_status',
        'date_of_birth',
        'active',
        'status',
        'order_id',
    ];
}
