<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Attempt to authenticate the user using the provided token
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
            }

            // Attach the authenticated user to the request
            $request->attributes->add(['user' => $user]);

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }
    }
}
