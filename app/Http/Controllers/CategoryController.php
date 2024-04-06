<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
   /**
     * Display a view of index page categories.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('category', ['categories' => $categories]);
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
            $category = Category::create($request->all());
            return response()->json(['message' => 'Category created successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create category.'], 500);
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
            $category = Category::findOrFail($id);
            return response()->json(['message' => 'Category retrieved successfully.', 'data' => $category], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Category not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve category.'], 500);
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
            $category = Category::findOrFail($id);
            $category->update($request->all());
            return response()->json(['message' => 'Category updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update category.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $category = Category::findOrFail($id);
            $category->deleteOrFail();
            return response()->json(['message' => 'Category deleted successfully.'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Failed to delete category.'], 500);
        }
    }
}
