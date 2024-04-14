<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'date', 
        'client_name', 
        'client_contact', 
        'sub_total', 
        'vat', 
        'total_amount', 
        'discount', 
        'grand_total', 
        'paid', 
        'due', 
        'payment_type', 
        'payment_status', 
        'payment_place', 
        'gstn', 
        'order_status', 
        'user_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<int, string>
     */
    public function getOrderItem(){
        return $this->hasMany('App\Models\Order_item');
    }
}
