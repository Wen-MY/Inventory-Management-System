<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a view of index page orders.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $orders = Order::paginate(10);
        $products = Product::all();
        
        $orderIds = $orders->pluck('id')->toArray();
        $orderItems = Order_item::whereIn('order_id', $orderIds)->get();
        
        $itemCounts = [];
        foreach ($orderItems as $item) {
            if (!isset($itemCounts[$item->order_id])) {
                $itemCounts[$item->order_id] = 0;
            }
            $itemCounts[$item->order_id]++;
        }

        return view('order', ['products' => $products, 'orders' => $orders, 'orderItems' => $orderItems, 'itemCounts' => $itemCounts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
        $request->validate([
            'orderDate' => 'required',
            'clientName' => 'required|string|max:255',
            'clientContact' => 'required|string|max:255',
            'subTotalValue' => 'required|numeric',
            'vatValue' => 'required|numeric',
            'totalAmountValue' => 'required|numeric',
            'discount' => 'required|numeric',
            'grandTotalValue' => 'required|numeric',
            'paid' => 'required|numeric',
            'dueValue' => 'required|numeric',
            'paymentType' => 'required|integer',
            'paymentStatus' => 'required|integer', 
            'paymentPlace' => 'required|integer',
            'gstn' => 'nullable|string|max:255|regex:/^[0-9A-Za-z]+$/',
        ]);
        */
        try{
            $order = new Order;
            $orderDate = Carbon::createFromFormat('m/d/Y', $request->orderDate)->format('Y-m-d');
            $order->date = $orderDate;
            $order->client_name = $request->clientName;
            $order->client_contact = $request->clientContact;
            $order->sub_total = $request->subTotalValue;
            $order->total_amount = $request->totalAmountValue;
            $order->discount = $request->discount;
            $order->grand_total = $request->grandTotalValue;
            $order->vat = $request->vatValue;
            $order->gstn = $request->gstn;
            $order->paid = $request->paid;
            $order->due = $request->dueValue;
            $order->payment_type = $request->paymentType;
            $order->payment_status = $request->paymentStatus;
            $order->payment_place = $request->paymentPlace;
            $order->user_id = $request->user_id;
            $order->save();
            $insertedId = $order->id;
        
            foreach ($request->productName as $index => $productName) {
                $orderItem = new Order_item();
                $orderItem->order_id = $insertedId;
                $orderItem->product_id = $productName;
                $orderItem->rate = $request->rateValue[$index];
                $orderItem->quantity = $request->quantity[$index];
                $orderItem->total = $request->totalValue[$index];
                $orderItem->save();
            }
            return response()->json(['message' => 'Order created successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create order: ' . $e->getMessage()], 500);
        }     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $order = Order::findOrFail($id);
            $orderDate = Carbon::createFromFormat('Y-m-d', $order->date)->format('m/d/Y');
            $order->date = $orderDate;
            return response()->json(['message' => 'Order retrieved successfully.', 'order' => $order], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve order.'], 500);
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     * 
     */
    public function update(Request $request, $id)
    {
        //uncomment for report
        // $request->validate([
        //     'clientName' => 'required|string',
        //     'clientContact' => 'required|numeric',
        //     'subTotalValue' => 'required|numeric',
        //     'vatValue' => 'required|numeric',
        //     'totalAmountValue' => 'required|numeric',
        //     'discount' => 'required|numeric',
        //     'grandTotalValue' => 'required|numeric',
        //     'paid' => 'required|numeric',
        //     'dueValue' => 'required|numeric',
        //     'paymentTypeSelect' => 'required|numeric',
        //     'paymentStatusSelect' => 'required|numeric', 
        //     'paymentPlaceSelect' => 'required|numeric',
        //     'gstn' => 'required|numeric',
        //     'rateValue' => 'required|numeric',
        //     'quantity' => 'required|numeric',
        //     'totalValue' => 'required|numeric',
        // ]);

        try {
            $order = Order::findOrFail($id);
            $orderDate = Carbon::createFromFormat('m/d/Y', $request->orderDate)->format('Y-m-d');
            $order->date = $orderDate;
            $order->client_name = $request->clientName;
            $order->client_contact = $request->clientContact;
            $order->sub_total = $request->subTotalValue;
            $order->total_amount = $request->totalAmountValue;
            $order->discount = $request->discount;
            $order->grand_total = $request->grandTotalValue;
            $order->vat = $request->vatValue;
            $order->gstn = $request->gstn;
            $order->paid = $request->paid;
            $order->due = $request->dueValue;
            $order->payment_type = $request->paymentTypeSelect;
            $order->payment_status = $request->paymentStatusSelect;
            $order->payment_place = $request->paymentPlaceSelect;
            $order->save();
        
            foreach ($request->productName as $index => $productName) {
                $orderItemId = $request->orderItemId[$index]; 
                $orderItem = Order_item::findOrFail($orderItemId);
                $orderItem->product_id = $productName;
                $orderItem->rate = $request->rateValue[$index];
                $orderItem->quantity = $request->quantity[$index];
                $orderItem->total = $request->totalValue[$index];
                $orderItem->save();
            }
        
            return response()->json(['message' => 'Order updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update order: ' . $e->getMessage()], 500);
        }        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
    
            Order_item::where('order_id', $id)->delete();
    
            return response()->json(['message' => 'Order deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete order.'], 500);
        }
    }

    /**
     * Soft delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function softDelete($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        
        $order->delete();
        
        return response()->json(['message' => 'Order soft deleted'], 200);
    }

    /**
     * Display a listing of the soft deleted resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function softDeleted()
    {
        $orders = Order::onlyTrashed()->get();
        return response()->json(['orders' => $orders], 200);
    }

    /**
     * Restore the specified soft deleted resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $order = Order::withTrashed()->find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        
        $order->restore();
        
        return response()->json(['message' => 'Order restored successfully'], 200);
    }
}
