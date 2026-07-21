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

use App\Http\Controllers\RoutineController;

// Routine Builder routes (all require login)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/routines', [RoutineController::class, 'index']);              // Get all of the user's routines
    Route::post('/routines', [RoutineController::class, 'store']);            // Create a new routine
    Route::get('/routines/{id}', [RoutineController::class, 'show']);         // View one routine
    Route::put('/routines/{id}', [RoutineController::class, 'update']);       // Update routine name/description
    Route::delete('/routines/{id}', [RoutineController::class, 'destroy']);   // Delete a routine

    Route::post('/routines/{id}/exercises', [RoutineController::class, 'addExercise']);              // Add exercise to routine
    Route::delete('/routines/{id}/exercises/{exerciseId}', [RoutineController::class, 'removeExercise']); // Remove exercise from routine
});