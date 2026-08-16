<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\Exercise;
use App\Models\Bookmark;
use App\Models\UserWorkoutProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class WorkoutController extends Controller
{
    /**
     * Display a listing of workouts.
     */
    public function index(Request $request)
    {
        $query = Workout::with(['creator', 'exercises'])->active();

        // Apply filters
        if ($request->has('category') && $request->category && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        if ($request->has('difficulty') && $request->difficulty) {
            $query->where('difficulty', $request->difficulty);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('featured') && $request->featured) {
            $query->where('is_featured', true);
        }

        // Sorting
        $sort = $request->get('sort', 'title');
        $direction = $request->get('direction', 'asc');
        $allowedSorts = ['title', 'category', 'difficulty', 'duration', 'calories_burned', 'created_at'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        }

        $workouts = $query->paginate(9)->appends($request->all());

        // Get categories for filter
        $categories = Workout::distinct()->pluck('category');
        $difficulties = Workout::distinct()->pluck('difficulty');

        // Get bookmarked workout IDs for current user
        $bookmarkedIds = [];
        $completedIds = [];
        if (auth()->check()) {
            $bookmarkedIds = Bookmark::where('user_id', auth()->id())
                ->where('bookmarkable_type', Workout::class)
                ->pluck('bookmarkable_id')
                ->toArray();

            $completedIds = UserWorkoutProgress::where('user_id', auth()->id())
                ->whereNotNull('completed_at')
                ->pluck('workout_id')
                ->toArray();
        }

        return view('pages.workouts.index', compact(
            'workouts',
            'categories',
            'difficulties',
            'bookmarkedIds',
            'completedIds',
            'sort',
            'direction'
        ));
    }

    /**
     * Show the form for creating a new workout.
     */
    public function create()
    {
        $exercises = Exercise::active()->orderBy('name')->get();
        return view('pages.workouts.create', compact('exercises'));
    }

    /**
     * Store a newly created workout in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:workouts',
            'description' => 'required|string',
            'category' => 'required|string',
            'difficulty' => 'required|string',
            'duration' => 'required|integer|min:1',
            'calories_burned' => 'required|integer|min:0',
            'target_muscles' => 'required|array|min:1',
            'equipment' => 'nullable|array',
            'instructions' => 'nullable|array',
            'image_url' => 'nullable|url',
            'level' => 'nullable|integer|min:1|max:5',
            'exercises' => 'required|array|min:1',
            'exercises.*.id' => 'required|exists:exercises,id',
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.reps' => 'required|string',
            'exercises.*.rest' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::transaction(function () use ($request) {
            $workout = Workout::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'difficulty' => $request->difficulty,
                'duration' => $request->duration,
                'calories_burned' => $request->calories_burned,
                'target_muscles' => $request->target_muscles,
                'equipment' => $request->equipment,
                'instructions' => $request->instructions,
                'image_url' => $request->image_url,
                'level' => $request->level ?? 1,
                'created_by' => auth()->id(),
            ]);

            // Attach exercises
            foreach ($request->exercises as $index => $exerciseData) {
                $workout->exercises()->attach($exerciseData['id'], [
                    'sets' => $exerciseData['sets'],
                    'reps' => $exerciseData['reps'],
                    'rest_seconds' => $exerciseData['rest'] ?? 60,
                    'order' => $index + 1,
                ]);
            }
        });

        return redirect()->route('workouts.index')
            ->with('success', 'Workout created successfully! 🎉');
    }

    /**
     * Display the specified workout.
     */
    public function show($id)
    {
        $workout = Workout::with(['exercises', 'creator', 'progress' => function($query) {
            $query->where('user_id', auth()->id());
        }])->findOrFail($id);

        $isBookmarked = auth()->check() && Bookmark::where('user_id', auth()->id())
            ->where('bookmarkable_id', $id)
            ->where('bookmarkable_type', Workout::class)
            ->exists();

        $hasCompleted = auth()->check() && UserWorkoutProgress::where('user_id', auth()->id())
            ->where('workout_id', $id)
            ->whereNotNull('completed_at')
            ->exists();

        $inProgress = auth()->check() && UserWorkoutProgress::where('user_id', auth()->id())
            ->where('workout_id', $id)
            ->whereNull('completed_at')
            ->exists();

        // Get user's progress for this workout
        $userProgress = null;
        if (auth()->check()) {
            $userProgress = UserWorkoutProgress::where('user_id', auth()->id())
                ->where('workout_id', $id)
                ->whereNotNull('completed_at')
                ->orderBy('completed_at', 'desc')
                ->first();
        }

        // Get related workouts
        $relatedWorkouts = Workout::active()
            ->where('category', $workout->category)
            ->where('id', '!=', $id)
            ->limit(4)
            ->get();

        return view('pages.workouts.show', compact(
            'workout',
            'isBookmarked',
            'hasCompleted',
            'inProgress',
            'userProgress',
            'relatedWorkouts'
        ));
    }

    /**
     * Show the form for editing the specified workout.
     */
    public function edit($id)
    {
        $workout = Workout::with('exercises')->findOrFail($id);
        $exercises = Exercise::active()->orderBy('name')->get();
        return view('pages.workouts.edit', compact('workout', 'exercises'));
    }

    /**
     * Update the specified workout in storage.
     */
    public function update(Request $request, $id)
    {
        $workout = Workout::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|unique:workouts,title,' . $id,
            'description' => 'required|string',
            'category' => 'required|string',
            'difficulty' => 'required|string',
            'duration' => 'required|integer|min:1',
            'calories_burned' => 'required|integer|min:0',
            'target_muscles' => 'required|array|min:1',
            'equipment' => 'nullable|array',
            'instructions' => 'nullable|array',
            'image_url' => 'nullable|url',
            'level' => 'nullable|integer|min:1|max:5',
            'exercises' => 'required|array|min:1',
            'exercises.*.id' => 'required|exists:exercises,id',
            'exercises.*.sets' => 'required|integer|min:1',
            'exercises.*.reps' => 'required|string',
            'exercises.*.rest' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::transaction(function () use ($request, $workout) {
            $workout->update([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'difficulty' => $request->difficulty,
                'duration' => $request->duration,
                'calories_burned' => $request->calories_burned,
                'target_muscles' => $request->target_muscles,
                'equipment' => $request->equipment,
                'instructions' => $request->instructions,
                'image_url' => $request->image_url,
                'level' => $request->level ?? 1,
            ]);

            // Sync exercises
            $syncData = [];
            foreach ($request->exercises as $index => $exerciseData) {
                $syncData[$exerciseData['id']] = [
                    'sets' => $exerciseData['sets'],
                    'reps' => $exerciseData['reps'],
                    'rest_seconds' => $exerciseData['rest'] ?? 60,
                    'order' => $index + 1,
                ];
            }
            $workout->exercises()->sync($syncData);
        });

        return redirect()->route('workouts.index')
            ->with('success', 'Workout updated successfully! 🎉');
    }

    /**
     * Remove the specified workout from storage.
     */
    public function destroy($id)
    {
        $workout = Workout::findOrFail($id);
        $workout->is_active = false;
        $workout->save();

        return redirect()->route('workouts.index')
            ->with('success', 'Workout deleted successfully!');
    }

    /**
     * Start a workout.
     */
    public function start($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $workout = Workout::findOrFail($id);

        // Check if already started
        $existing = UserWorkoutProgress::where('user_id', auth()->id())
            ->where('workout_id', $id)
            ->whereNull('completed_at')
            ->first();

        if ($existing) {
            return redirect()->route('workouts.show', $id)
                ->with('info', 'You already have this workout in progress!');
        }

        // Create progress record
        $progress = UserWorkoutProgress::create([
            'user_id' => auth()->id(),
            'workout_id' => $id,
            'started_at' => now(),
        ]);

        return redirect()->route('workouts.show', $id)
            ->with('success', 'Workout started! Keep going! 💪');
    }

    /**
     * Complete a workout.
     */
    public function complete(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $workout = Workout::findOrFail($id);

        $progress = UserWorkoutProgress::where('user_id', auth()->id())
            ->where('workout_id', $id)
            ->whereNull('completed_at')
            ->latest()
            ->first();

        if (!$progress) {
            return redirect()->route('workouts.show', $id)
                ->with('error', 'You haven\'t started this workout.');
        }

        $validator = Validator::make($request->all(), [
            'duration' => 'nullable|integer|min:1',
            'calories_burned' => 'nullable|integer|min:0',
            'rating' => 'nullable|integer|min:1|max:5',
            'notes' => 'nullable|string',
            'exercise_results' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $progress->update([
            'completed_at' => now(),
            'duration' => $request->duration ?? $workout->duration,
            'calories_burned' => $request->calories_burned ?? $workout->calories_burned,
            'rating' => $request->rating,
            'notes' => $request->notes,
            'exercise_results' => $request->exercise_results,
        ]);

        // Create notifications for completion
        $this->createCompletionNotification($workout);

        return redirect()->route('workouts.show', $id)
            ->with('success', 'Workout completed! Great job! 🎉');
    }

    /**
     * Toggle bookmark for workout.
     */
    public function bookmark($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $workout = Workout::findOrFail($id);
        
        $bookmark = Bookmark::where('user_id', auth()->id())
            ->where('bookmarkable_id', $id)
            ->where('bookmarkable_type', Workout::class)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $bookmarked = false;
            $message = 'Workout removed from bookmarks';
        } else {
            Bookmark::create([
                'user_id' => auth()->id(),
                'bookmarkable_id' => $id,
                'bookmarkable_type' => Workout::class,
            ]);
            $bookmarked = true;
            $message = 'Workout bookmarked successfully';
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked,
            'message' => $message
        ]);
    }

    /**
     * Get workout progress for the current user.
     */
    public function getProgress($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $progress = UserWorkoutProgress::where('user_id', auth()->id())
            ->where('workout_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($progress);
    }

    /**
     * Get workout statistics.
     */
    public function getStats($id)
    {
        $workout = Workout::findOrFail($id);
        
        $stats = [
            'total_completed' => UserWorkoutProgress::where('workout_id', $id)
                ->whereNotNull('completed_at')
                ->count(),
            'average_rating' => UserWorkoutProgress::where('workout_id', $id)
                ->whereNotNull('rating')
                ->avg('rating'),
            'average_duration' => UserWorkoutProgress::where('workout_id', $id)
                ->whereNotNull('duration')
                ->avg('duration'),
            'user_completed' => auth()->check() && UserWorkoutProgress::where('user_id', auth()->id())
                ->where('workout_id', $id)
                ->whereNotNull('completed_at')
                ->exists(),
        ];

        return response()->json($stats);
    }

    /**
     * Create completion notification.
     */
    private function createCompletionNotification($workout)
    {
        // This will be implemented when notifications are fully set up
        // For now, we'll just log it
        \Log::info('Workout completed: ' . $workout->title . ' by user ' . auth()->id());
    }
}