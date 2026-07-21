<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Bookmark;
use App\Models\UserExerciseProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    /**
     * Display a listing of exercises with full filtering and sorting.
     */
    public function index(Request $request)
    {
        $query = Exercise::active();

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('body_part', 'LIKE', "%{$search}%");
            });
        }

        // Filters
        if ($request->has('body_part') && $request->body_part && $request->body_part !== 'All') {
            $query->where('body_part', $request->body_part);
        }

        if ($request->has('difficulty') && $request->difficulty && $request->difficulty !== 'All') {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->has('equipment') && $request->equipment && $request->equipment !== 'All') {
            $query->whereJsonContains('equipment', $request->equipment);
        }

        if ($request->has('muscle_group') && $request->muscle_group && $request->muscle_group !== 'All') {
            $query->whereJsonContains('muscle_groups', $request->muscle_group);
        }

        // Sorting
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        
        $allowedSorts = ['name', 'body_part', 'difficulty', 'calories_per_hour', 'created_at'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        }

        $exercises = $query->paginate(12)->appends($request->all());

        // Get filter options
        $bodyParts = Exercise::distinct()->pluck('body_part');
        $difficulties = Exercise::distinct()->pluck('difficulty');
        $allEquipment = Exercise::select('equipment')->get()->pluck('equipment')->flatten()->unique()->values();
        $allMuscles = Exercise::select('muscle_groups')->get()->pluck('muscle_groups')->flatten()->unique()->values();

        // Get bookmarked exercise IDs for current user
        $bookmarkedIds = [];
        if (auth()->check()) {
            $bookmarkedIds = Bookmark::where('user_id', auth()->id())
                ->where('bookmarkable_type', Exercise::class)
                ->pluck('bookmarkable_id')
                ->toArray();
        }

        // Get completed exercise IDs for current user
        $completedIds = [];
        if (auth()->check()) {
            $completedIds = UserExerciseProgress::where('user_id', auth()->id())
                ->whereNotNull('completed_at')
                ->pluck('exercise_id')
                ->toArray();
        }

        return view('pages.exercises.index', compact(
            'exercises',
            'bodyParts',
            'difficulties',
            'allEquipment',
            'allMuscles',
            'bookmarkedIds',
            'completedIds',
            'sort',
            'direction'
        ));
    }

    /**
     * Show the form for creating a new exercise.
     */
    public function create()
    {
        return view('pages.exercises.create');
    }

    /**
     * Store a newly created exercise in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:exercises',
            'description' => 'nullable|string',
            'body_part' => 'required|string',
            'difficulty' => 'required|string',
            'equipment' => 'required|array|min:1',
            'muscle_groups' => 'required|array|min:1',
            'instructions' => 'nullable|array',
            'calories_per_hour' => 'nullable|integer|min:0',
            'image_url' => 'nullable|url',
            'video_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $exercise = Exercise::create($request->all());

        return redirect()->route('exercises.index')
            ->with('success', 'Exercise created successfully!');
    }

    /**
     * Display the specified exercise with full details.
     */
    public function show($id)
    {
        $exercise = Exercise::with(['workouts'])->findOrFail($id);
        
        $isBookmarked = auth()->check() && Bookmark::where('user_id', auth()->id())
            ->where('bookmarkable_id', $id)
            ->where('bookmarkable_type', Exercise::class)
            ->exists();

        // Get user's progress for this exercise
        $progress = null;
        $totalCompleted = UserExerciseProgress::where('exercise_id', $id)
            ->whereNotNull('completed_at')
            ->count();

        if (auth()->check()) {
            $progress = UserExerciseProgress::where('user_id', auth()->id())
                ->where('exercise_id', $id)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        // Get related exercises
        $relatedExercises = Exercise::active()
            ->where('body_part', $exercise->body_part)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();

        return view('pages.exercises.show', compact(
            'exercise',
            'isBookmarked',
            'progress',
            'totalCompleted',
            'relatedExercises'
        ));
    }

    /**
     * Show the form for editing the specified exercise.
     */
    public function edit($id)
    {
        $exercise = Exercise::findOrFail($id);
        return view('pages.exercises.edit', compact('exercise'));
    }

    /**
     * Update the specified exercise in storage.
     */
    public function update(Request $request, $id)
    {
        $exercise = Exercise::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:exercises,name,' . $id,
            'description' => 'nullable|string',
            'body_part' => 'required|string',
            'difficulty' => 'required|string',
            'equipment' => 'required|array|min:1',
            'muscle_groups' => 'required|array|min:1',
            'instructions' => 'nullable|array',
            'calories_per_hour' => 'nullable|integer|min:0',
            'image_url' => 'nullable|url',
            'video_url' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $exercise->update($request->all());

        return redirect()->route('exercises.index')
            ->with('success', 'Exercise updated successfully!');
    }

    /**
     * Remove the specified exercise from storage.
     */
    public function destroy($id)
    {
        $exercise = Exercise::findOrFail($id);
        $exercise->is_active = false;
        $exercise->save();

        return redirect()->route('exercises.index')
            ->with('success', 'Exercise deleted successfully!');
    }

    /**
     * Get exercise details for modal/quick view.
     */
    public function getDetails($id)
    {
        $exercise = Exercise::findOrFail($id);
        $isBookmarked = auth()->check() && Bookmark::where('user_id', auth()->id())
            ->where('bookmarkable_id', $id)
            ->where('bookmarkable_type', Exercise::class)
            ->exists();

        return response()->json([
            'exercise' => $exercise,
            'is_bookmarked' => $isBookmarked
        ]);
    }

    /**
     * Search exercises for autocomplete.
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        $exercises = Exercise::active()
            ->where('name', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['id', 'name', 'body_part', 'difficulty', 'image_url']);

        return response()->json(['results' => $exercises]);
    }

    /**
     * Toggle bookmark for exercise.
     */
    public function toggleBookmark($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $exercise = Exercise::findOrFail($id);
        
        $bookmark = Bookmark::where('user_id', auth()->id())
            ->where('bookmarkable_id', $id)
            ->where('bookmarkable_type', Exercise::class)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $bookmarked = false;
            $message = 'Exercise removed from bookmarks';
        } else {
            Bookmark::create([
                'user_id' => auth()->id(),
                'bookmarkable_id' => $id,
                'bookmarkable_type' => Exercise::class,
            ]);
            $bookmarked = true;
            $message = 'Exercise bookmarked successfully';
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked,
            'message' => $message
        ]);
    }

    /**
     * Start an exercise (record start time).
     */
    public function start($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $exercise = Exercise::findOrFail($id);

        // Check if already in progress
        $existing = UserExerciseProgress::where('user_id', auth()->id())
            ->where('exercise_id', $id)
            ->whereNull('completed_at')
            ->first();

        if ($existing) {
            return redirect()->route('exercises.show', $id)
                ->with('info', 'You already have this exercise in progress!');
        }

        // Create progress record
        $progress = UserExerciseProgress::create([
            'user_id' => auth()->id(),
            'exercise_id' => $id,
            'started_at' => now(),
        ]);

        return redirect()->route('exercises.show', $id)
            ->with('success', 'Exercise started! Keep going! 💪');
    }

    /**
     * Complete an exercise (record completion time and details).
     */
    public function complete(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $exercise = Exercise::findOrFail($id);

        $progress = UserExerciseProgress::where('user_id', auth()->id())
            ->where('exercise_id', $id)
            ->whereNull('completed_at')
            ->latest()
            ->first();

        if (!$progress) {
            return redirect()->route('exercises.show', $id)
                ->with('error', 'You haven\'t started this exercise.');
        }

        $validator = Validator::make($request->all(), [
            'duration' => 'nullable|integer|min:1',
            'sets' => 'nullable|integer|min:1',
            'reps' => 'nullable|integer|min:1',
            'weight' => 'nullable|numeric|min:0',
            'rating' => 'nullable|integer|min:1|max:5',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $progress->update([
            'completed_at' => now(),
            'duration' => $request->duration ?? 5,
            'sets' => $request->sets,
            'reps' => $request->reps,
            'weight' => $request->weight,
            'rating' => $request->rating,
            'notes' => $request->notes,
            'calories_burned' => $request->duration ? 
                round(($exercise->calories_per_hour / 60) * $request->duration) : 
                $exercise->calories_per_hour,
        ]);

        return redirect()->route('exercises.show', $id)
            ->with('success', 'Exercise completed! Great job! 🎉');
    }

    /**
     * Get exercise progress for the current user.
     */
    public function getProgress($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $progress = UserExerciseProgress::where('user_id', auth()->id())
            ->where('exercise_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($progress);
    }

    /**
     * Get user's exercise statistics.
     */
    public function getStats()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = auth()->id();

        $stats = [
            'total_completed' => UserExerciseProgress::where('user_id', $userId)
                ->whereNotNull('completed_at')
                ->count(),
            'total_time' => UserExerciseProgress::where('user_id', $userId)
                ->whereNotNull('duration')
                ->sum('duration'),
            'total_calories' => UserExerciseProgress::where('user_id', $userId)
                ->whereNotNull('calories_burned')
                ->sum('calories_burned'),
            'average_rating' => UserExerciseProgress::where('user_id', $userId)
                ->whereNotNull('rating')
                ->avg('rating'),
            'this_week' => UserExerciseProgress::where('user_id', $userId)
                ->whereNotNull('completed_at')
                ->whereBetween('completed_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'today' => UserExerciseProgress::where('user_id', $userId)
                ->whereNotNull('completed_at')
                ->whereDate('completed_at', today())
                ->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get exercise history for the current user.
     */
    public function getHistory(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $query = UserExerciseProgress::with('exercise')
            ->where('user_id', auth()->id())
            ->whereNotNull('completed_at');

        // Filter by date range
        if ($request->has('from') && $request->from) {
            $query->whereDate('completed_at', '>=', $request->from);
        }
        if ($request->has('to') && $request->to) {
            $query->whereDate('completed_at', '<=', $request->to);
        }

        $history = $query->orderBy('completed_at', 'desc')
            ->paginate(20);

        return view('pages.exercises.history', compact('history'));
    }
}