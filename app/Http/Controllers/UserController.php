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
}
