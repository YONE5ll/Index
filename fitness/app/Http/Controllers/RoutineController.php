<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;

class RoutineController extends Controller
{
    /**
     * Get all routines belonging to the logged-in user.
     */
    public function index(Request $request)
    {
        $routines = Routine::where('user_id', $request->user()->id)
                            ->with('exercises') // include exercise details
                            ->get();

        return response()->json($routines, 200);
    }

    /**
     * Create a new routine with a list of exercises.
     * Expected JSON body:
     * {
     *   "name": "Push Day",
     *   "description": "Chest, shoulders, triceps",
     *   "exercises": [
     *     { "exercise_id": 1, "sets": 4, "reps": 8, "order_index": 1 },
     *     { "exercise_id": 5, "sets": 3, "reps": 12, "order_index": 2 }
     *   ]
     * }
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'exercises' => 'required|array|min:1',
            'exercises.*.exercise_id' => 'required|exists:exercises,id',
            'exercises.*.sets' => 'nullable|integer|min:1',
            'exercises.*.reps' => 'nullable|integer|min:1',
            'exercises.*.order_index' => 'nullable|integer',
        ]);

        // Create the routine, tied to the logged-in user
        $routine = Routine::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Attach each exercise to the routine with its sets/reps/order
        foreach ($request->exercises as $index => $exercise) {
            $routine->exercises()->attach($exercise['exercise_id'], [
                'sets' => $exercise['sets'] ?? 3,
                'reps' => $exercise['reps'] ?? 10,
                'order_index' => $exercise['order_index'] ?? $index,
            ]);
        }

        return response()->json([
            'message' => 'Routine created successfully',
            'routine' => $routine->load('exercises'),
        ], 201);
    }

    /**
     * Get a single routine with its exercises.
     * Only the owner can view it.
     */
    public function show(Request $request, $id)
    {
        $routine = Routine::where('id', $id)
                           ->where('user_id', $request->user()->id)
                           ->with('exercises')
                           ->first();

        if (!$routine) {
            return response()->json(['message' => 'Routine not found'], 404);
        }

        return response()->json($routine, 200);
    }

    /**
     * Update a routine's name/description (basic info only).
     */
    public function update(Request $request, $id)
    {
        $routine = Routine::where('id', $id)
                           ->where('user_id', $request->user()->id)
                           ->first();

        if (!$routine) {
            return response()->json(['message' => 'Routine not found'], 404);
        }

        $routine->update($request->only('name', 'description'));

        return response()->json([
            'message' => 'Routine updated successfully',
            'routine' => $routine,
        ], 200);
    }

    /**
     * Delete a routine (and its exercise links, via cascade).
     */
    public function destroy(Request $request, $id)
    {
        $routine = Routine::where('id', $id)
                           ->where('user_id', $request->user()->id)
                           ->first();

        if (!$routine) {
            return response()->json(['message' => 'Routine not found'], 404);
        }

        $routine->delete();

        return response()->json(['message' => 'Routine deleted successfully'], 200);
    }

    /**
     * Add a single exercise to an existing routine.
     * Body: { "exercise_id": 3, "sets": 4, "reps": 10, "order_index": 3 }
     */
    public function addExercise(Request $request, $id)
    {
        $routine = Routine::where('id', $id)
                           ->where('user_id', $request->user()->id)
                           ->first();

        if (!$routine) {
            return response()->json(['message' => 'Routine not found'], 404);
        }

        $request->validate([
            'exercise_id' => 'required|exists:exercises,id',
            'sets' => 'nullable|integer|min:1',
            'reps' => 'nullable|integer|min:1',
            'order_index' => 'nullable|integer',
        ]);

        $routine->exercises()->attach($request->exercise_id, [
            'sets' => $request->sets ?? 3,
            'reps' => $request->reps ?? 10,
            'order_index' => $request->order_index ?? 0,
        ]);

        return response()->json([
            'message' => 'Exercise added to routine',
            'routine' => $routine->load('exercises'),
        ], 200);
    }

    /**
     * Remove a single exercise from a routine.
     */
    public function removeExercise(Request $request, $id, $exerciseId)
    {
        $routine = Routine::where('id', $id)
                           ->where('user_id', $request->user()->id)
                           ->first();

        if (!$routine) {
            return response()->json(['message' => 'Routine not found'], 404);
        }

        $routine->exercises()->detach($exerciseId);

        return response()->json(['message' => 'Exercise removed from routine'], 200);
    }
}