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
        $this->authorize('viewAny',Brand::class);
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
        // $request->validate([
        //     'name' => 'required|string|max:255', 
        //     'status' => 'required|integer|in:0,1', 
        // ]);

        try {
            $this->authorizeForUser(auth('api')->user(),'create',Brand::class);
            Brand::create([
                'name' => $request->brandName,
                'status'=> $request->brandStatus,
            ]);

            return response()->json(['message' => 'Success to create brand.'], 200);
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
            $this->authorizeForUser(auth('api')->user(),'view',$brand);
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
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'status' => 'required|integer|in:0,1', // Assuming 'status' can be 0 or 1
        // ]);
        
        try {
            $brand= Brand::findOrFail($id);
            $this->authorizeForUser(auth('api')->user(),'update',$brand);
            $brand->update([
                'name' => $request->editBrandName,
                'status' => $request->editBrandStatus,
            ]);

            return response()->json(['message' => 'Success to update brand.'], 200);
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
        try {
            $brand = Brand::findOrFail($id);
            $this->authorizeForUser(auth('api')->user(),'delete',$brand);
            $brand->delete(); 
            return response()->json(['message' => 'Brand deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete brand.'], 500);
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
        $brand = Brand::withTrashed()->find($id);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }
        
        $brand->restore();
        
        return response()->json(['message' => 'Brand restored successfully'], 200);
    }
}
