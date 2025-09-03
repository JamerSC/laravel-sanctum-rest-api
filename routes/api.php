<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    // register endpoint '/register'
    Route::post('/register', [AuthController::class, 'register']);
    // login endpoint '/login'
    Route::post('/login', [AuthController::class,'login']);

    Route::middleware('auth:sanctum')->group(function () {
        // logout endpoint
        Route::post('/logout', [AuthController::class, 'logout']);

        // task api resource
        Route::apiResource('tasks', TaskController::class);
    });
});