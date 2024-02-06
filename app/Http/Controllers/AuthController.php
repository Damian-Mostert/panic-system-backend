<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user using Laravel's authentication
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Generate a unique ID for the user
            $generatedId = Str::uuid();

            // Store the generated ID in the database (assuming there's a 'generated_id' column in your users table)
            $user->update(['generated_id' => $generatedId]);

            // Generate a JWT token using the attempt method
            $token = JWTAuth::attempt($credentials);

            return response()->json([
                'status' => 'success',
                'message' => 'User logged in',
                'data' => [
                    'id' => $generatedId,
                    'token' => $token,
                ],
            ]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Login failed'], 401);
        }
    }
     public function getUser(Request $request)
    {
        
        $credentials = $request->only('id');
        $token = $request->bearerToken();
        try {
            // Attempt to authenticate the user using the provided token
            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
            }

            // Verify if the generated ID matches the one associated with the user
           if ($user['generated_id'] !== $credentials['id']) {
                return response()->json(['status' => 'error', 'message' => 'Invalid generated ID'], 401);
            }
 
            return response()->json([
                'status' => 'success',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => ""], 401);
        }
    }
}
