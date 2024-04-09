<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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
        return view('order', ['orders' => $orders]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'client_name' => 'required|string|max:255',
            'client_contact' => 'required|string|max:255',
            'sub_total' => 'required|numeric',
            'vat' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'discount' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'paid' => 'required|numeric',
            'due' => 'required|numeric',
            'payment_type' => 'required|integer',
            'payment_status' => 'required|integer', 
            'payment_place' => 'required|integer',
            'gstn' => 'nullable|string|max:255|regex:/^[0-9A-Za-z]+$/',
            'order_status' => 'nullable|integer', 
            'user_id' => 'required|integer',
        ]);
        try {
            $order = Order::create($request->all());
            return response()->json(['message' => 'Order created successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create order.'], 500);
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
            return response()->json(['message' => 'Order retrieved successfully.', 'data' => $order], 200);
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
        $request->validate([
            'date' => 'required|date',
            'client_name' => 'required|string|max:255',
            'client_contact' => 'required|string|max:255',
            'sub_total' => 'required|numeric',
            'vat' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'discount' => 'required|numeric',
            'grand_total' => 'required|numeric',
            'paid' => 'required|numeric',
            'due' => 'required|numeric',
            'payment_type' => 'required|integer',
            'payment_status' => 'required|integer', 
            'payment_place' => 'required|integer',
            'gstn' => 'nullable|string|max:255|regex:/^[0-9A-Za-z]+$/',
            'order_status' => 'nullable|integer', 
            'user_id' => 'required|integer',
        ]);
        try {
            $order = Order::findOrFail($id);
            $order->update($request->all());
            return response()->json(['message' => 'Order updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update order.'], 500);
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
        try{
            $order = Order::findOrFail($id);
            $order->deleteOrFail();
            return response()->json(['message' => 'Order deleted successfully.'], 200);
        }catch(\Exception $e){
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
