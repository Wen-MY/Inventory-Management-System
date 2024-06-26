<?php

namespace App\Http\Controllers;

use App\Models\Order_item;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|numeric',
            'rate' => 'required|numeric',
            'total' => 'required|numeric',
            'status' => 'required|integer',
        ]);
        try {
            $this->authorizeForUser(auth('api')->user(),'create',Order_item::class);
            $order_item = Order_item::create($request->all());
            return response()->json(['message' => 'Order_item created successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create order_item.'], 500);
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
            $order_item = Order_item::findOrFail($id);
            $this->authorizeForUser(auth('api')->user(),'view',$order_item);
            return response()->json(['message' => 'Order_item retrieved successfully.', 'data' => $order_item], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Order item not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve order item.'], 500);
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
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|numeric',
            'rate' => 'required|numeric',
            'total' => 'required|numeric',
            'status' => 'required|integer',
        ]);
        try {
            $order_item = Order_item::findOrFail($id);
            $this->authorizeForUser(auth('api')->user(),'update',$order_item);
            $order_item->update($request->all());
            return response()->json(['message' => 'Order_item updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update order item.'], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $order_item = Order_item::findOrFail($id);
            $this->authorizeForUser(auth('api')->user(),'delete',$order_item);
            $order_item->deleteOrFail();
            return response()->json(['message' => 'Order_item deleted successfully.'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Failed to delete order item.'], 500);
        }
    }
    /**
     * Restore the specified soft deleted resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $orderItem = Order_Item::withTrashed()->find($id);
        if (!$orderItem) {
            return response()->json(['message' => 'Order item not found'], 404);
        }
        
        $orderItem->restore();
        
        return response()->json(['message' => 'Order item restored successfully'], 200);
    }
}
