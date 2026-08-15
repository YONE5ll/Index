<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    /**
     * Display a listing of workouts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Sample workout categories
        $categories = [
            'Strength', 'Hypertrophy', 'Powerlifting', 'Calisthenics',
            'Yoga', 'HIIT', 'Cardio', 'CrossFit'
        ];
        
        // Sample workouts
        $workouts = $this->getSampleWorkouts();
        
        return view('pages.workouts.index', compact('categories', 'workouts'));
    }

    /**
     * Show the form for creating a new workout.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.workouts.create');
    }

    /**
     * Store a newly created workout in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate and store workout
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'duration' => 'required|integer|min:1',
            'calories_burned' => 'required|integer|min:1',
            'target_muscles' => 'required|array',
            'equipment' => 'nullable|array',
            'instructions' => 'required|array',
        ]);
        
        // Here you would save to database
        // Workout::create($validated);
        
        return redirect()->route('workouts.index')
            ->with('success', 'Workout created successfully!');
    }

    /**
     * Display the specified workout.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Get workout details
        $workout = $this->getWorkoutDetails($id);
        
        return view('pages.workouts.show', compact('workout'));
    }

    /**
     * Show the form for editing the specified workout.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Get workout for editing
        $workout = $this->getWorkoutDetails($id);
        
        return view('pages.workouts.edit', compact('workout'));
    }

    /**
     * Update the specified workout in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'duration' => 'required|integer|min:1',
        ]);
        
        // Update workout in database
        // $workout = Workout::findOrFail($id);
        // $workout->update($validated);
        
        return redirect()->route('workouts.index')
            ->with('success', 'Workout updated successfully!');
    }

    /**
     * Remove the specified workout from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Delete workout
        // $workout = Workout::findOrFail($id);
        // $workout->delete();
        
        return redirect()->route('workouts.index')
            ->with('success', 'Workout deleted successfully!');
    }

    /**
     * Start a workout.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start($id)
    {
        // Log workout start
        // WorkoutLog::create(['user_id' => auth()->id(), 'workout_id' => $id, 'started_at' => now()]);
        
        return redirect()->route('workouts.show', $id)
            ->with('success', 'Workout started! Good luck!');
    }

    /**
     * Bookmark a workout.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function bookmark($id)
    {
        // Toggle bookmark status
        // $bookmarked = auth()->user()->bookmarkedWorkouts()->toggle($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Bookmark toggled successfully'
        ]);
    }

    /**
     * Get sample workouts for demo.
     *
     * @return array
     */
    private function getSampleWorkouts()
    {
        return [
            [
                'id' => 1,
                'title' => 'Full Body Strength',
                'category' => 'Strength',
                'difficulty' => 'Intermediate',
                'duration' => '45 min',
                'calories' => 320,
                'muscles' => ['Chest', 'Back', 'Legs', 'Shoulders'],
                'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400&h=300&fit=crop',
                'bookmarked' => false
            ],
            [
                'id' => 2,
                'title' => 'HIIT Cardio Blast',
                'category' => 'HIIT',
                'difficulty' => 'Advanced',
                'duration' => '30 min',
                'calories' => 450,
                'muscles' => ['Full Body', 'Cardio'],
                'image' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=400&h=300&fit=crop',
                'bookmarked' => true
            ],
            [
                'id' => 3,
                'title' => 'Yoga Flow',
                'category' => 'Yoga',
                'difficulty' => 'Beginner',
                'duration' => '60 min',
                'calories' => 200,
                'muscles' => ['Core', 'Flexibility', 'Balance'],
                'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=400&h=300&fit=crop',
                'bookmarked' => false
            ],
        ];
    }

    /**
     * Get workout details.
     *
     * @param  int  $id
     * @return array
     */
    private function getWorkoutDetails($id)
    {
        return [
            'id' => $id,
            'title' => 'Full Body Strength',
            'category' => 'Strength',
            'description' => 'A complete full body workout focusing on compound movements for maximum strength gains.',
            'difficulty' => 'Intermediate',
            'duration' => '45 min',
            'calories' => 320,
            'muscles' => ['Chest', 'Back', 'Legs', 'Shoulders', 'Core'],
            'equipment' => ['Barbell', 'Dumbbells', 'Bench', 'Pull-up Bar'],
            'instructions' => [
                'Warm up with 5 minutes of light cardio',
                'Perform 3 sets of 8-12 reps for each exercise',
                'Rest 60-90 seconds between sets',
                'Cool down with static stretching'
            ],
            'exercises' => [
                ['name' => 'Bench Press', 'sets' => 4, 'reps' => '8-12'],
                ['name' => 'Deadlift', 'sets' => 3, 'reps' => '5-8'],
                ['name' => 'Squats', 'sets' => 4, 'reps' => '8-12'],
                ['name' => 'Pull-ups', 'sets' => 3, 'reps' => '8-12'],
            ],
            'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&h=400&fit=crop',
            'video_placeholder' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=800&h=400&fit=crop',
        ];
    }
}