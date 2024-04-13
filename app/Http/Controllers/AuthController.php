<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;

use Validator;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'username' => 'required|username',
            'password' => 'required|string|min:5',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        if (!$token = Auth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // Store the authenticated user in the session
        $user = Auth::user();
        Session::put('user', $user);
        $token = Auth::guard('api')->attempt($validator->validated());
        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
    
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)],
            ['role' => 'staff']
        ));
    
        return redirect('/login');
    }    

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth()->logout();
        Session::forget('user');
        return redirect('/');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        $jwtGuard = Auth::guard('api');
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $jwtGuard->factory()->getTTL() * 60,
            'user' => auth()->user()
        ])->header('Authorization', $token);
    }

    public function showLoginForm()
    {
        if(auth()->check()) {
            return redirect('/home');
        }
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }
}
