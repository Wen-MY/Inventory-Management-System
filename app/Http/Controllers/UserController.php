<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::paginate(10); //password will not visible
        return view('user', ['users' => $users]);
    }
    //if(session('user.id'))

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'username' => 'required|max:50',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,auditor,staff'
        ], [
            'email.unique' => 'This email address is already in use.'
        ]);

        try {
            User::create([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'email' => $request->email,
                'role' => $request->role,
            ]);
            return response()->json(['message' => 'User created successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create user.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        /*
        $req->validate([
            'username' => 'required|max:50',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,auditor,staff'
        ]);
        */
        try{
            $user = User::findOrFail($id);
            
            $user->update($req->all());
            return response()->json(['message' => 'User updated successfully.'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Failed to update user.'], 500);
        }
    }
    /*
    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            // Update the attributes
            $product->name = $request->input('editProductName');
            $product->quantity = $request->input('editQuantity');
            $product->rate = $request->input('editRate');
            $product->brand_id = $request->input('editBrandName');
            $product->category_id = $request->input('editCategoryName');
            $product->status = $request->input('editProductStatus');

            // Save the changes
            $product->save();

            return response()->json(['message' => 'Product updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update product.'], 500);
        }
    }
*/
    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = User::findOrFail($id);
            $user->deleteOrFail();
            return response()->json(['message' => 'User deleted successfully.'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Failed to delete user.'], 500);
        }
    }
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(['message' => 'User retrieved successfully.', 'user' => $user], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve user.'], 500);
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
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        
        $user->delete();
        
        return response()->json(['message' => 'User soft deleted'], 200);
    }

    /**
     * Display a listing of the soft deleted resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function softDeleted()
    {
        $users = User::onlyTrashed()->get();
        return response()->json(['users' => $users], 200);
    }

    /**
     * Restore the specified soft deleted resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        
        $user->restore();
        
        return response()->json(['message' => 'User restored successfully'], 200);
    }
}