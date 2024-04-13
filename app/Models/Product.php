<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name', 
        'image', 
        'brand_id', 
        'category_id',
        'quantity', 
        'rate', 
        'active', 
        'status'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<int, string>
     */

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

}
