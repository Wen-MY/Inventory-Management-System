<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a view of index page products.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('product', ['products' => $products]);
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
            'image' => 'required',
            'name' => 'required|min:3',
            'quantity' => 'required|numeric',
            'rate' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'status' => 'required|numeric',
        ]);
        try {
            $product = Product::create($request->all());
            return response()->json(['message' => 'Product created successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create product.'], 500);
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
            $product = Product::findOrFail($id);
            return response()->json(['message' => 'Product retrieved successfully.', 'data' => $product], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Product not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve product.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     * 
     * THIS ONLY UPDATE PRODUCT INFO NOT INCLUDE IMAGE
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'quantity' => 'required|numeric',
            'rate' => 'required|numeric',
            'brand_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'status' => 'required|numeric',
        ]);
        try {
            $product = Product::findOrFail($id);
            $product->update($request->all());
            return response()->json(['message' => 'Product updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update product.'], 500);
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     * 
     * THIS ONLY UPDATE PRODUCT IMAGE
     */
    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required'
        ]);
        try {
            $product = Product::findOrFail($id);
            $this->authorize('update', $product); //check user role
            $product->update($request->all());
            return response()->json(['message' => 'Product updated successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update product.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $product = Product::findOrFail($id);
            $product->deleteOrFail();
            return response()->json(['message' => 'Product deleted successfully.'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Failed to delete product.'], 500);
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
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        $product->delete();
        
        return response()->json(['message' => 'Product soft deleted'], 200);
    }

    /**
     * Display a listing of the soft deleted resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function softDeleted()
    {
        $products = Product::onlyTrashed()->get();
        return response()->json(['products' => $products], 200);
    }

    /**
     * Restore the specified soft deleted resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $product = Product::withTrashed()->find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        $product->restore();
        
        return response()->json(['message' => 'Product restored successfully'], 200);
    }
}
