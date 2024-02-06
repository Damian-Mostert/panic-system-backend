<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PanicController;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/get-user', [AuthController::class, 'getUser']);
//middleware
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/create-user', [UserController::class, 'createUser']);
    Route::post('/send-panic', [PanicController::class, 'sendPanic']);
    Route::post('/update-panic', [PanicController::class, 'updatePanic']);
    Route::post('/panic-history', [PanicController::class, 'panicHistory']);
});
