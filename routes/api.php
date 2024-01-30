<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;


Route::get('/create-user', [UserController::class, 'createUser']);

Route::post('/login', function(Request $request){
    $data = json_decode($request->getContent(), true);
    
    //auth data
    $email = $data['email'];
    $password = $data['password'];
    
// Check/get user using Eloquent
$user = User::where('email', $email)
    ->first();

// If user exists and password is correct
  $response = [
        'status' => 'error',
        'message' => 'Login failed'
    ];
// If user exists and password is correct
if ($user && Hash::check($password, $user->password)) {
    $response = [
        'status' => 'success',
        'message' => 'User logged in',
        'data' => [
            'name' => $user->name,
            'email' => $email
        ],
    ];
   }
    return response()->json($response);
});    


Route::post('/new-panic', function(Request $request){
    $data = json_decode($request->getContent(), true);

    // Assuming 'user_id' is part of your JSON data
    $userId = $data['user_id'];

    // Insert a new panic into the database
    $panicId = DB::table('panics')->insertGetId([
        'user_id' => $userId,
        'status' => 'active',
        // Add other relevant data
    ]);

    // Create a JSON response
    $response = [
        'status' => 'success',
        'message' => 'New panic created',
        'data' => ['panic_id' => $panicId],
    ];

    // Return the JSON response
    return response()->json($response);
});

Route::post('/cancel-panic', function(Request $request){
    $data = json_decode($request->getContent(), true);

    // Assuming 'panic_id' is part of your JSON data
    $panicId = $data['panic_id'];

    // Update the status of the specified panic to 'canceled'
    DB::table('panics')->where('id', $panicId)->update(['status' => 'canceled']);

    // Create a JSON response
    $response = [
        'status' => 'success',
        'message' => 'Panic canceled',
        'data' => ['panic_id' => $panicId],
    ];

    // Return the JSON response
    return response()->json($response);
});


Route::post('/panic-history', function(Request $request){
    // Retrieve all panic data from the database
    $panics = DB::table('panics')->get();

    // Create a JSON response
    $response = [
        'status' => 'success',
        'message' => 'Panic history retrieved',
        'data' => ['panics' => $panics],
    ];

    // Return the JSON response
    return response()->json($response);
});