<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        
        // Sample data - In a real app, this would come from your database
        $data = [
            'user' => $user,
            'stats' => $this->getStats(),
            'weeklyCalories' => $this->getWeeklyCalories(),
            'weightProgress' => $this->getWeightProgress(),
            'workoutFrequency' => $this->getWorkoutFrequency(),
            'recentActivities' => $this->getRecentActivities(),
            'dailyGoals' => $this->getDailyGoals(),
            'motivationalQuote' => $this->getMotivationalQuote(),
        ];
        
        return view('pages.dashboard.index', $data);
    }
    
    /**
     * Get dashboard statistics.
     *
     * @return array
     */
    private function getStats()
    {
        return [
            'calories' => ['value' => '1,845', 'target' => '2,200', 'progress' => 84],
            'weight' => ['value' => '75.5', 'target' => '72', 'unit' => 'kg', 'progress' => 70],
            'water' => ['value' => '1.8', 'target' => '3', 'unit' => 'L', 'progress' => 60],
            'workout' => ['value' => '45', 'target' => '60', 'unit' => 'min', 'progress' => 75],
            'steps' => ['value' => '8,234', 'target' => '10,000', 'progress' => 82],
            'sleep' => ['value' => '7.5', 'target' => '8', 'unit' => 'hrs', 'progress' => 94],
            'bmi' => ['value' => '22.4', 'target' => '22', 'progress' => 90],
            'bodyFat' => ['value' => '15.2', 'target' => '12', 'unit' => '%', 'progress' => 65],
        ];
    }
    
    /**
     * Get weekly calories data.
     *
     * @return array
     */
    private function getWeeklyCalories()
    {
        return [
            'days' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'values' => [1800, 2100, 1950, 2200, 2050, 2400, 1900],
        ];
    }
    
    /**
     * Get weight progress data.
     *
     * @return array
     */
    private function getWeightProgress()
    {
        return [
            'weeks' => ['W1', 'W2', 'W3', 'W4', 'W5', 'W6', 'W7'],
            'values' => [78, 77.2, 76.5, 76, 75.3, 74.8, 75.5],
        ];
    }
    
    /**
     * Get workout frequency data.
     *
     * @return array
     */
    private function getWorkoutFrequency()
    {
        return [
            'days' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'values' => [1, 0, 1, 1, 0, 1, 0],
        ];
    }
    
    /**
     * Get recent activities.
     *
     * @return array
     */
    private function getRecentActivities()
    {
        return [
            [
                'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                'color' => 'emerald',
                'title' => 'Completed HIIT Workout',
                'time' => '2 hours ago'
            ],
            [
                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'blue',
                'title' => 'Logged Lunch: 450 calories',
                'time' => '4 hours ago'
            ],
            [
                'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                'color' => 'blue',
                'title' => 'Drank 500ml water',
                'time' => '5 hours ago'
            ],
            [
                'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                'color' => 'orange',
                'title' => 'Earned "Early Bird" achievement',
                'time' => 'Yesterday'
            ],
        ];
    }
    
    /**
     * Get daily goals progress.
     *
     * @return array
     */
    private function getDailyGoals()
    {
        return [
            ['label' => 'Workout', 'progress' => 75, 'color' => 'emerald'],
            ['label' => 'Calories', 'progress' => 85, 'color' => 'blue'],
            ['label' => 'Water', 'progress' => 60, 'color' => 'blue'],
        ];
    }
    
    /**
     * Get a motivational quote.
     *
     * @return array
     */
    private function getMotivationalQuote()
    {
        $quotes = [
            [
                'text' => 'The only bad workout is the one that didn\'t happen.',
                'author' => 'Unknown'
            ],
            [
                'text' => 'Success starts with self-discipline.',
                'author' => 'Unknown'
            ],
            [
                'text' => 'Your body can stand almost anything. It\'s your mind you have to convince.',
                'author' => 'Unknown'
            ],
            [
                'text' => 'The pain you feel today will be the strength you feel tomorrow.',
                'author' => 'Unknown'
            ],
        ];
        
        return $quotes[array_rand($quotes)];
    }
}