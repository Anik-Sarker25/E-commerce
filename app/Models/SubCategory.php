<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'image',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function products() {
        return $this->hasMany(Product::class, 'subcategory_id');
    }

    public function childcategories() {
        return $this->hasMany(ChildCategory::class, 'subcategory_id');
    }

}
