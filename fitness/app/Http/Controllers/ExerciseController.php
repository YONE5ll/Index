<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;

class ExerciseController extends Controller
{
    /**
     * Get all exercises, or filter by category if provided.
     * Example: /api/exercises?category=Chest
     * If no category is passed, or category is "All", returns everything.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');

        // If no category given, or "All Exercises" selected, return everything
        if (!$category || strtolower($category) === 'all' || strtolower($category) === 'all exercises') {
            $exercises = Exercise::all();
        } else {
            // Filter exercises where muscle_group matches the category (case-insensitive)
            $exercises = Exercise::whereRaw('LOWER(muscle_group) = ?', [strtolower($category)])->get();
        }

        return response()->json([
            'category' => $category ?? 'All Exercises',
            'count' => $exercises->count(),
            'exercises' => $exercises,
        ], 200);
    }

    /**
     * Get a single exercise by ID.
     * Example: /api/exercises/3
     */
    public function show($id)
    {
        $exercise = Exercise::find($id);

        if (!$exercise) {
            return response()->json(['message' => 'Exercise not found'], 404);
        }

        return response()->json($exercise, 200);
    }

    /**
     * Create a new exercise (basic CRUD - optional for admin use later).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'muscle_group' => 'required|string|max:255',
            'description' => 'required|string',
            'image_path' => 'required|string',
        ]);

        $exercise = Exercise::create($request->all());

        return response()->json([
            'message' => 'Exercise created successfully',
            'exercise' => $exercise,
        ], 201);
    }

    /**
     * Update an existing exercise (basic CRUD - optional for admin use later).
     */
    public function update(Request $request, $id)
    {
        $exercise = Exercise::find($id);

        if (!$exercise) {
            return response()->json(['message' => 'Exercise not found'], 404);
        }

        $exercise->update($request->all());

        return response()->json([
            'message' => 'Exercise updated successfully',
            'exercise' => $exercise,
        ], 200);
    }

    /**
     * Delete an exercise (basic CRUD - optional for admin use later).
     */
    public function destroy($id)
    {
        $exercise = Exercise::find($id);

        if (!$exercise) {
            return response()->json(['message' => 'Exercise not found'], 404);
        }

        $exercise->delete();

        return response()->json(['message' => 'Exercise deleted successfully'], 200);
    }
}