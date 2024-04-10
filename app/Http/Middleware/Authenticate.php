<?php

// app/Http/Middleware/Authenticate.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return redirect('/login'); // Redirect to login if user not found
            }
        } catch (\Exception $e) {
            return redirect('/login'); // Redirect to login on token error
        }

        return $next($request);
    }
}

