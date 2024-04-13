<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_item extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_item';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'rate',
        'total',
        'status'
    ];
    
    public function order(){
        return $this->belongsTo('App\Models\Order');
    }
    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<int, string>
     */
}
