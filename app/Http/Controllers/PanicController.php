<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panic;
use Illuminate\Support\Facades\DB;

class PanicController extends Controller
{
    public function sendPanic(Request $request)
    {
        $request->validate([
            'status' => 'required|string',
            'type' => 'required|string',
            'details' => 'required|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        $data = $request->all();
        // Insert a new panic into the database using Eloquent
        $panic = Panic::create([
            'status' => $data['status'],
            'type' => $data['type'],
            'details' => $data['details'],
            'longitude' => $data['longitude'],
            'latitude' => $data['latitude'],
            // Add other relevant data
        ]);

        // Create a JSON response
        $response = [
            'status' => 'success',
            'message' => 'New panic created',
            'data' => $data
        ];

        // Return the JSON response
        return response()->json($response);
    }

    public function updatePanic(Request $request)
    {
        $data = $request->json()->all();

        // Update the status of the specified panic to 'canceled'
        DB::table('panics')->where('id', $data["id"])->update(['canceled' => $data["canceled"],'status' => $data["status"]]);

        // Create a JSON response
        $response = [
            'status' => 'success',
            'message' => 'Panic canceled',
            'data' => [],
        ];

        // Return the JSON response
        return response()->json($response);
    }

    public function panicHistory(Request $request)
    {
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
    }
}
