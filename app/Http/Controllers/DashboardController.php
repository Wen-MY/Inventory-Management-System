<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $countProduct = Product::where('status', 1)->count();
        
        $countOrder = Order::where('order_status', 1)->count();
        
        $totalRevenue = Order::where('order_status', 1)->sum('paid');
        
        $countLowStock = Product::where('quantity', '<=', 3)->where('status', 1)->count();
        
        $userwiseQuery = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.order_status', 1)
            ->select('users.username', \DB::raw('SUM(orders.grand_total) as totalorder'))
            ->groupBy('orders.user_id')
            ->get();

        return view('dashboard', [
            'countProduct' => $countProduct,
            'countOrder' => $countOrder,
            'totalRevenue' => $totalRevenue,
            'countLowStock' => $countLowStock,
            'userwiseQuery' => $userwiseQuery
        ]);
    }
}
