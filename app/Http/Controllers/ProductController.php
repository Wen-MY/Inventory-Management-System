<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
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
         //authorization check
        $this->authorize('viewAny', Product::class);

        $products = Product::paginate(10);
        $brands = Brand::where('active', 1)->where('status', 1)->get();
        $categories = Category::where('active', 1)->where('status', 1)->get();

        return view('product', ['products' => $products, 'brands' => $brands, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse 
     */
    public function store(Request $request)
    {
        $request->validate([
            'productImage' => 'required',
            'productName' => 'required',
            'quantity' => 'required|numeric',
            'rate' => 'required|numeric',
            'productStatus' => 'required|numeric',
        ]);

        try {
            $this->authorizeForUser(auth('api')->user(),'create',Product::class);
           
            $imageName = time().'.'.$request->productImage->extension();  
            $request->productImage->move(public_path('images'), $imageName);

            Product::create([
                'image' => 'images/' . $imageName, 
                'name' => $request->productName,
                'quantity' => $request->quantity,
                'rate' => $request->rate,
                'brand_id' => $request->brandName,
                'category_id' => $request->categoryName,
                'status' => $request->productStatus,
            ]);
            return response()->json(['message' => 'Product created successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create product: ' . $e->getMessage()], 500);
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

            //authorization check
            $this->authorizeForUser(auth('api')->user(),'view',$product);
            
            return response()->json(['message' => 'Product retrieved successfully.', 'product' => $product], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Product not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve product.'], 500);
        }
    }

    public function showAll(){
        try {
            $product = Product::all();
            $this->authorizeForUser(auth('api')->user(),'viewAny',Product::class);
            return response()->json(['message' => 'Products retrieved successfully.', 'product' => $product], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Products not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve products.'], 500);
        }
    }

    public function updateProductImage(Request $request, $id)
    {
        $request->validate([
            'productImage' => 'required',
            'productName' => 'required',
            'quantity' => 'required|numeric',
            'rate' => 'required|numeric',
            'productStatus' => 'required|numeric',
        ]);
        
        try {
            $product = Product::findOrFail($id);
            $this->authorizeForUser(auth('api')->user(),'update',$product);
            if ($request->hasFile('editProductImage')) {
                $image = $request->file('editProductImage');
                $imageName = time().'.'.$image->extension();  
                $image->move(public_path('images'), $imageName);
                $product->image = 'images/' . $imageName; 
            }
    
            $product->save();
    
            return response()->json(['message' => 'Product image updated successfully.'], 200);
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
     * THIS ONLY UPDATE PRODUCT INFO NOT INCLUDE IMAGE
     */
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $this->authorizeForUser(auth('api')->user(),'update',$product);
            $product->name = $request->input('editProductName');
            $product->quantity = $request->input('editQuantity');
            $product->rate = $request->input('editRate');
            $product->brand_id = $request->input('editBrandName');
            $product->category_id = $request->input('editCategoryName');
            $product->status = $request->input('editProductStatus');
            
            $product->save();
    
            return response()->json(['message' => 'Product updated successfully.'], 200);
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
            $this->authorizeForUser(auth('api')->user(),'delete',$product);
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully.'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Failed to delete product.'], 500);
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
        $product = Product::withTrashed()->find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        $product->restore();
        
        return response()->json(['message' => 'Product restored successfully'], 200);
    }
}
