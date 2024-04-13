<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index () {
        return view('report');
    }

    public function generateReport(Request $request)
    {
        if ($request->has(['startDate', 'endDate'])) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
    
            $start_date = Carbon::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
            $end_date = Carbon::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');
    
            $orders = Order::where('order_status', 1)
                ->whereBetween('date', [$start_date, $end_date])
                ->get();

            $totalAmount = $orders->sum('grand_total');
    
            return response()->json([
                'orders' => $orders,
                'totalAmount' => $totalAmount
            ]);
        } else {
            return response()->json(['error' => 'Missing startDate or endDate parameter.'], 400);
        }
    }
}
