<?php

namespace App\Models;

use Devfaysal\BangladeshGeocode\Models\Union;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function union()
    {
        return $this->belongsTo(Union::class);
    }

}
