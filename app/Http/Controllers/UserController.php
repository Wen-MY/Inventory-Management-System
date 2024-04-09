<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        //return all user 
        $users = User::all(); //password will not visible
        return view('user',compact($users));
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
            'username' => 'required|max:50',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,auditor,staff'
        ]);
        try {
            $user = User::create($request->all());
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
        $req->validate([
            'username' => 'required|max:50',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,auditor,staff'
        ]);
        try{
            $user = User::findOrFail($id);
            
            $user->update($req->all());
            return response()->json(['message' => 'User updated successfully.'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Failed to update user.'], 500);
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
            $user = User::findOrFail($id);
            $user->deleteOrFail();
            return response()->json(['message' => 'User deleted successfully.'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Failed to delete user.'], 500);
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
