<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Panic;

Route::get('/create-user', [UserController::class, 'createUser']);

Route::post('/login', function(Request $request){
    $data = json_decode($request->getContent(), true);

    // Auth data
    $email = $data['email'];
    $password = $data['password'];

    // Check/get user using Eloquent
    $user = User::where('email', $email)->first();

    // Initialize response
    $response = [
        'status' => 'error',
        'message' => 'Login failed'
    ];

    // If user exists and password is correct
    if ($user && Hash::check($password, $user->password)) {
        // Generate a unique ID for the user
        $generatedId = Str::uuid();

        // Store the generated ID in the database (assuming there's a 'generated_id' column in your users table)
        $user->update(['generated_id' => $generatedId]);

        // Update the response with the generated ID
        $response = [
            'status' => 'success',
            'message' => 'User logged in',
            'data' => [
                'id_num' => $user->id,
                'id' => $generatedId,
                'name' => $user->name,
                'email' => $email
            ],
        ];
    }

    return response()->json($response);
});


Route::post('/send-panic', function(Request $request) {
    $data = json_decode($request->getContent(), true);

    // Insert a new panic into the database using Eloquent
    $panic = Panic::create([
        'data' => json_encode($data), // Serialize the array before storing
        // Add other relevant data
    ]);

    // Create a JSON response
    $response = [
        'status' => 'success',
        'message' => 'New panic created',
        'data' => $data,
    ];

    // Return the JSON response
    return response()->json($response);
});

Route::post('/update-panic', function(Request $request){
    $data = json_decode($request->getContent(), true);

   // Update the status of the specified panic to 'canceled'
    DB::table('panics')->where('id', $data["id"])->update(['canceled' => $data["canceled"]]);

    // Create a JSON response
    $response = [
        'status' => 'success',
        'message' => 'Panic canceled',
        'data' => $data,
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
        'data' => $panics,
    ];

    // Return the JSON response
    return response()->json($response);
});

