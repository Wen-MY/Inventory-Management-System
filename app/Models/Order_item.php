<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;
    protected $table = 'order_item';
    protected $timestamps = false;
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'quantity',
        'rate',
        'total',
        'status'
    ];
    public function getOrder(){
        return $this->hasOne('App\Models\Order');
    }
    public function getProduct(){
        return $this->hasOne('App\Models\Product');
    }

}
