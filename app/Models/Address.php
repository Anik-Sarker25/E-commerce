<?php

namespace App\Models;

use Devfaysal\BangladeshGeocode\Models\District;
use Devfaysal\BangladeshGeocode\Models\Division;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'delivery_place',
        'address',
        'upazila',
        'city',
        'state',
        'country',
        'postal_code',
        'is_default',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function division() {
        return $this->belongsTo(Division::class, 'state', 'id');
    }
    public function district() {
        return $this->belongsTo(District::class, 'city', 'id');
    }
    public function upazilas() {
        return $this->belongsTo(Upazila::class, 'upazila', 'id');
    }
}
