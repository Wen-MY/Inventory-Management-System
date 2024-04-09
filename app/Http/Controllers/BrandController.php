<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a view of index page brands.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $brands = Brand::paginate(10);
        return view('brand', ['brands' => $brands]);
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
            'name' => 'required|string|max:255',
            'active' => 'required|integer|in:0,1', 
            'status' => 'required|integer|in:0,1', 
        ]);
        try {
            $brand = Brand::create($request->all());
            return response()->json(['message' => 'Brand created successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create brand.'], 500);
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
            $brand = Brand::findOrFail($id);
            return response()->json(['message' => 'Brand retrieved successfully.', 'data' => $brand], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Brand not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve brand.'], 500);
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
            'name' => 'required|string|max:255',
            'active' => 'required|integer|in:0,1', // Assuming 'active' can be 0 or 1
            'status' => 'required|integer|in:0,1', // Assuming 'status' can be 0 or 1
        ]);
        try {
            $brand = Brand::findOrFail($id);
            $brand->update($request->all());
            return response()->json(['message' => 'Brand updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update brand.'], 500);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $brand = Brand::findOrFail($id);
            $brand->deleteOrFail();
            return response()->json(['message' => 'Brand deleted successfully.'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Failed to delete brand.'], 500);
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
        $brand = Brand::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }
        
        $brand->delete();
        
        return response()->json(['message' => 'Brand soft deleted'], 200);
    }

    /**
     * Display a listing of the soft deleted resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function softDeleted()
    {
        $brands = Brand::onlyTrashed()->get();
        return response()->json(['brands' => $brands], 200);
    }

    /**
     * Restore the specified soft deleted resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $brand = Brand::withTrashed()->find($id);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }
        
        $brand->restore();
        
        return response()->json(['message' => 'Brand restored successfully'], 200);
    }
}
