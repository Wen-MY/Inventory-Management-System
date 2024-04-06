<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    public $timestamps = true;

    protected $fillable = [
        'name', 
        'image', 
        'brand_id', 
        'categories_id', 
        'quantity', 
        'rate', 
        'active', 
        'status'];

    protected $guarded = ['product_id'];
}
