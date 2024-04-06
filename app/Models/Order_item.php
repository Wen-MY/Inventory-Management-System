<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;
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
    
    public function getOrder(){
        return $this->belongsTo('App\Models\Order');
    }
    public function getProduct(){
        return $this->hasOne('App\Models\Product');
    }

}
