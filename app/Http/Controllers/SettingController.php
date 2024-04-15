<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('setting', compact('user'));
    }
    
    public function changeUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|max:50',
        ]);
        $user = Auth::guard('api')->user(); //get user from token submited
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        $this->authorizeForUser(auth('api')->user(),'update',$user);
        $user->username = $request->input('username');
        $user->save();

        return response()->json(['message' => 'Username changed successfully.'], 200);
    }

    public function changePassword(Request $request)
    {
        /*
        $request->validate([
            'password' => 'required|min:8',
            'npassword' => 'required|min:8|confirmed',
        ]);
        */
        $user = Auth::guard('api')->user(); //get user from token submited
        
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }
        $this->authorizeForUser(auth('api')->user(),'update',$user);
        $user->password = bcrypt($request->input('npassword'));
        $user->save();

        return response()->json(['message' => 'Password changed successfully.'], 200);
    }
}
