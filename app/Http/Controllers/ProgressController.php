<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgressController extends Controller
{
    /**
     * Display the progress page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'weightData' => $this->getWeightData(),
            'bodyFatData' => $this->getBodyFatData(),
            'caloriesData' => $this->getCaloriesData(),
            'workoutStreak' => 15,
            'achievements' => $this->getAchievements(),
            'monthlyStats' => $this->getMonthlyStats(),
            'beforeAfterPhotos' => $this->getBeforeAfterPhotos(),
        ];
        
        return view('pages.progress.index', $data);
    }

    /**
     * Update weight.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateWeight(Request $request)
    {
        $validated = $request->validate([
            'weight' => 'required|numeric|min:20|max:300',
            'date' => 'required|date',
        ]);
        
        // Save weight to database
        // WeightLog::create($validated + ['user_id' => auth()->id()]);
        
        return redirect()->route('progress.index')
            ->with('success', 'Weight logged successfully!');
    }

    /**
     * Upload progress photos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadPhotos(Request $request)
    {
        $request->validate([
            'before_photo' => 'required|image|max:5120',
            'after_photo' => 'required|image|max:5120',
            'date' => 'required|date',
        ]);
        
        // Handle file uploads
        // $beforePath = $request->file('before_photo')->store('progress', 'public');
        // $afterPath = $request->file('after_photo')->store('progress', 'public');
        
        return redirect()->route('progress.index')
            ->with('success', 'Photos uploaded successfully!');
    }

    /**
     * Get weight data.
     *
     * @return array
     */
    private function getWeightData()
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            'values' => [82, 81, 79.5, 78, 77, 75.5, 75.5],
        ];
    }

    /**
     * Get body fat data.
     *
     * @return array
     */
    private function getBodyFatData()
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            'values' => [22, 21, 20, 19, 18, 16.5, 15.2],
        ];
    }

    /**
     * Get calories data.
     *
     * @return array
     */
    private function getCaloriesData()
    {
        return [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'consumed' => [1800, 2100, 1950, 2200, 2050, 2400, 1900],
            'burned' => [300, 250, 400, 350, 200, 450, 300],
        ];
    }

    /**
     * Get achievements.
     *
     * @return array
     */
    private function getAchievements()
    {
        return [
            ['name' => 'First Workout', 'icon' => '🏋️', 'date' => 'Jan 15, 2024'],
            ['name' => '5-Day Streak', 'icon' => '🔥', 'date' => 'Jan 20, 2024'],
            ['name' => '10kg Lost', 'icon' => '🎯', 'date' => 'Mar 1, 2024'],
            ['name' => '100 Workouts', 'icon' => '💪', 'date' => 'Jun 15, 2024'],
        ];
    }

    /**
     * Get monthly statistics.
     *
     * @return array
     */
    private function getMonthlyStats()
    {
        return [
            'total_workouts' => 22,
            'total_calories_burned' => 8500,
            'weight_change' => -2.5,
            'avg_workout_duration' => 45,
            'streak' => 15,
            'best_workout' => '45 min HIIT - 450 calories',
        ];
    }

    /**
     * Get before and after photos.
     *
     * @return array
     */
    private function getBeforeAfterPhotos()
    {
        return [
            'before' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=400&h=400&fit=crop',
            'after' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400&h=400&fit=crop',
        ];
    }
}