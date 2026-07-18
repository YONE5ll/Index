<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/dashboard', function (Request $request) {
    return response()->json([
        'message' => 'Welcome to our Fitness App',
        'user' => $request->user(),
    ]);
});
use App\Http\Controllers\ExerciseController;

// Exercise Library routes
Route::get('/exercises', [ExerciseController::class, 'index']);       // Get all exercises, or filter by ?category=
Route::get('/exercises/{id}', [ExerciseController::class, 'show']);   // Get single exercise
Route::post('/exercises', [ExerciseController::class, 'store']);      // Create exercise
Route::put('/exercises/{id}', [ExerciseController::class, 'update']); // Update exercise
Route::delete('/exercises/{id}', [ExerciseController::class, 'destroy']); // Delete exercise