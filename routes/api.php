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

// /api/v1/**
Route::prefix('v1')->group(function () {
    // register endpoint '/register'
    Route::post('/register', [AuthController::class, 'register']);
    // login endpoint '/login'
    Route::post('/login', [AuthController::class,'login']);
    // Middleware using sanctum
    Route::middleware('auth:sanctum')->group(function () {
        // logout endpoint
        Route::post('/logout', [AuthController::class, 'logout']);

        // apiResource() automatically creates the routes
        //Route::apiResource('tasks', TaskController::class);

        // get all tasks
        Route::get('/tasks', [TaskController::class,'index']);
        // get task by id
        Route::get('/tasks/{task}', [TaskController::class, 'show']);
        // create a tasks
        Route::post('/tasks', [TaskController::class,'store']);
        // update a tasks
        Route::put('/tasks/{task}', [TaskController::class,'update']);
        // delete a tasks
        Route::delete('/tasks/{task}', [TaskController::class,'destroy']);
    });
});