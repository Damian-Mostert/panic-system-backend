<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

         $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]); 

       if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
        }

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
        $token = $request->bearerToken();
        try {
            // Attempt to authenticate the user using the provided token
            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
            }

           $userFromDb = User::where('generated_id', $user['generated_id'])->first();

            if (!$userFromDb) {
                return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
            }
            // Verify if the generated ID matches the one associated with the user

 
            return response()->json([
                'status' => 'success',
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => ""], 401);
        }
    }
}
