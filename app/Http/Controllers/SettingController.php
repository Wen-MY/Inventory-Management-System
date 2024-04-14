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
            'user_id' => 'required', // Assuming user_id is sent in the request
            'username' => 'required|max:50',
        ]);

        $user = User::find($request->input('user_id'));
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->username = $request->input('username');
        $user->save();

        return redirect()->back()->with('success', 'Username changed successfully.');
    }

    public function changePassword(Request $request)
    {
        /*
        $request->validate([
            'user_id' => 'required', // Assuming user_id is sent in the request
            'password' => 'required|min:8',
            'npassword' => 'required|min:8|confirmed',
        ]);
        */
        $user = User::find($request->input('user_id'));
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Validate current password if needed
        // Perform password change logic
        $user->password = bcrypt($request->input('npassword'));
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully.');
    }
}
