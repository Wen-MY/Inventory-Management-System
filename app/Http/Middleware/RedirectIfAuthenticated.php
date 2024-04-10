<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth; // Import JWTAuth facade

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            // If the token is valid, user is authenticated, redirect to home
            return redirect('/home');
        } catch (\Exception $e) {
            // If the token is not valid or user not found, continue to the next middleware
            return $next($request);
        }
    }
}
