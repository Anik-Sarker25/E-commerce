<?php

namespace App\Models;

use Devfaysal\BangladeshGeocode\Models\District;
use Devfaysal\BangladeshGeocode\Models\Division;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'phone',
        'address',
        'password',
        'show_password',
        'birthday',
        'country_id',
        'division_id',
        'district_id',
        'upazila_id',
        'union_id',
        'gender',
        'status',
        'role',
        'verification_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function division() {
        return $this->belongsTo(Division::class, 'division_id', 'id');
    }
    public function district() {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function upazilas() {
        return $this->belongsTo(Upazila::class, 'upazila_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }


}
