<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Exercise;
use App\Models\Workout;
use App\Models\UserExerciseProgress;
use App\Models\UserWorkoutProgress;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with real data.
     */
    public function index()
    {
        $user = auth()->user();
        $userId = $user->id;

        // Get today's date
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // === STATS CARDS ===
        
        // Today's Calories (from completed exercises today)
        $todayCalories = UserExerciseProgress::where('user_id', $userId)
            ->whereDate('completed_at', $today)
            ->sum('calories_burned');
        
        // Current Weight (get latest weight from user or progress)
        $currentWeight = $this->getCurrentWeight($userId);
        
        // Water Intake (placeholder - you can add a water tracking table)
        $waterIntake = $this->getWaterIntake($userId);
        
        // Today's Workout Time
        $todayWorkoutTime = UserExerciseProgress::where('user_id', $userId)
            ->whereDate('completed_at', $today)
            ->sum('duration');
        
        // Steps (placeholder - integrate with fitness tracker)
        $steps = $this->getSteps($userId);
        
        // Sleep (placeholder)
        $sleep = $this->getSleep($userId);
        
        // BMI
        $bmi = $this->calculateBMI($userId);
        
        // Body Fat % (placeholder)
        $bodyFat = $this->getBodyFat($userId);

        // === CHARTS DATA ===
        
        // Calories this week
        $weeklyCalories = $this->getWeeklyCalories($userId);
        
        // Weight progress
        $weightProgress = $this->getWeightProgress($userId);
        
        // Workout frequency
        $workoutFrequency = $this->getWorkoutFrequency($userId);

        // === RECENT ACTIVITY ===
        $recentActivities = $this->getRecentActivities($userId);

        // === DAILY GOALS ===
        $dailyGoals = $this->getDailyGoals($userId);

        // === MOTIVATIONAL QUOTE ===
        $quote = $this->getMotivationalQuote();

        // === STATISTICS ===
        $stats = [
            'total_exercises' => UserExerciseProgress::where('user_id', $userId)
                ->whereNotNull('completed_at')
                ->count(),
            'total_workouts' => UserWorkoutProgress::where('user_id', $userId)
                ->whereNotNull('completed_at')
                ->count(),
            'total_calories' => UserExerciseProgress::where('user_id', $userId)
                ->sum('calories_burned'),
            'total_minutes' => UserExerciseProgress::where('user_id', $userId)
                ->sum('duration'),
            'streak' => $this->getCurrentStreak($userId),
        ];

        return view('pages.dashboard.index', compact(
            'user',
            'todayCalories',
            'currentWeight',
            'waterIntake',
            'todayWorkoutTime',
            'steps',
            'sleep',
            'bmi',
            'bodyFat',
            'weeklyCalories',
            'weightProgress',
            'workoutFrequency',
            'recentActivities',
            'dailyGoals',
            'quote',
            'stats'
        ));
    }

    /**
     * Get current weight from user progress.
     */
    private function getCurrentWeight($userId)
    {
        $latest = UserExerciseProgress::where('user_id', $userId)
            ->whereNotNull('weight')
            ->latest('completed_at')
            ->first();
            
        return $latest ? $latest->weight : 75.5;
    }

    /**
     * Get water intake (placeholder - implement water tracking table).
     */
    private function getWaterIntake($userId)
    {
        // You can create a water_intake table
        // For now, return placeholder
        return [
            'current' => 1.8,
            'target' => 3.0,
            'unit' => 'L',
            'progress' => 60
        ];
    }

    /**
     * Get steps (placeholder - integrate with fitness tracker API).
     */
    private function getSteps($userId)
    {
        return [
            'current' => 8234,
            'target' => 10000,
            'progress' => 82
        ];
    }

    /**
     * Get sleep (placeholder).
     */
    private function getSleep($userId)
    {
        return [
            'current' => 7.5,
            'target' => 8,
            'unit' => 'hrs',
            'progress' => 94
        ];
    }

    /**
     * Calculate BMI.
     */
    private function calculateBMI($userId)
    {
        $user = User::find($userId);
        // You would need height and weight fields in users table
        // For now, return placeholder
        return 22.4;
    }

    /**
     * Get body fat percentage.
     */
    private function getBodyFat($userId)
    {
        // Placeholder - you'd need a body_fat_measurements table
        return 15.2;
    }

    /**
     * Get weekly calories data.
     */
    private function getWeeklyCalories($userId)
    {
        $days = [];
        $values = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('D');
            
            $calories = UserExerciseProgress::where('user_id', $userId)
                ->whereDate('completed_at', $date)
                ->sum('calories_burned');
            
            $values[] = $calories ?: 0;
        }

        return [
            'days' => $days,
            'values' => $values,
        ];
    }

    /**
     * Get weight progress data.
     */
    private function getWeightProgress($userId)
    {
        $weights = UserExerciseProgress::where('user_id', $userId)
            ->whereNotNull('weight')
            ->orderBy('completed_at', 'asc')
            ->take(7)
            ->get();

        if ($weights->isEmpty()) {
            return [
                'weeks' => ['W1', 'W2', 'W3', 'W4', 'W5', 'W6', 'W7'],
                'values' => [78, 77.2, 76.5, 76, 75.3, 74.8, 75.5],
            ];
        }

        return [
            'weeks' => $weights->pluck('completed_at')->map(function($date) {
                return $date->format('M d');
            })->toArray(),
            'values' => $weights->pluck('weight')->toArray(),
        ];
    }

    /**
     * Get workout frequency data.
     */
    private function getWorkoutFrequency($userId)
    {
        $days = [];
        $values = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('D');
            
            $count = UserExerciseProgress::where('user_id', $userId)
                ->whereDate('completed_at', $date)
                ->count();
            
            $values[] = $count ?: 0;
        }

        return [
            'days' => $days,
            'values' => $values,
        ];
    }

    /**
     * Get recent activities.
     */
    private function getRecentActivities($userId)
    {
        $activities = UserExerciseProgress::with('exercise')
            ->where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'desc')
            ->limit(10)
            ->get();

        if ($activities->isEmpty()) {
            return [
                [
                    'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                    'color' => 'emerald',
                    'title' => 'Start your fitness journey!',
                    'time' => 'Complete your first exercise to track progress',
                    'is_placeholder' => true
                ],
                [
                    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                    'color' => 'blue',
                    'title' => 'Explore exercises',
                    'time' => 'Browse our exercise library to get started',
                    'is_placeholder' => true
                ]
            ];
        }

        $result = [];
        foreach ($activities as $activity) {
            $exercise = $activity->exercise;
            $result[] = [
                'icon' => $this->getExerciseIcon($exercise->body_part ?? ''),
                'color' => $this->getColorByBodyPart($exercise->body_part ?? ''),
                'title' => 'Completed: ' . ($exercise->name ?? 'Exercise'),
                'time' => $activity->completed_at->diffForHumans(),
                'is_placeholder' => false,
                'details' => $activity->duration ? "{$activity->duration} min" : '',
                'calories' => $activity->calories_burned ? "{$activity->calories_burned} cal" : '',
            ];
        }

        return $result;
    }

    /**
     * Get exercise icon by body part.
     */
    private function getExerciseIcon($bodyPart)
    {
        $icons = [
            'Chest' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            'Back' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
            'Legs' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'Shoulders' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9',
            'Core' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
            'Arms' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1',
        ];
        return $icons[$bodyPart] ?? 'M13 10V3L4 14h7v7l9-11h-7z';
    }

    /**
     * Get color by body part.
     */
    private function getColorByBodyPart($bodyPart)
    {
        $colors = [
            'Chest' => 'emerald',
            'Back' => 'blue',
            'Legs' => 'orange',
            'Shoulders' => 'purple',
            'Core' => 'yellow',
            'Arms' => 'pink',
            'Full Body' => 'emerald',
        ];
        return $colors[$bodyPart] ?? 'emerald';
    }

    /**
     * Get daily goals progress.
     */
    private function getDailyGoals($userId)
    {
        $today = Carbon::today();
        
        // Workout goal (30 min recommended)
        $todayDuration = UserExerciseProgress::where('user_id', $userId)
            ->whereDate('completed_at', $today)
            ->sum('duration');
        $workoutProgress = min(($todayDuration / 30) * 100, 100);

        // Calories goal (500 cal recommended)
        $todayCalories = UserExerciseProgress::where('user_id', $userId)
            ->whereDate('completed_at', $today)
            ->sum('calories_burned');
        $caloriesProgress = min(($todayCalories / 500) * 100, 100);

        // Water goal (3L)
        $waterIntake = $this->getWaterIntake($userId);
        $waterProgress = $waterIntake['progress'] ?? 60;

        return [
            ['label' => 'Workout', 'progress' => round($workoutProgress), 'color' => 'emerald'],
            ['label' => 'Calories', 'progress' => round($caloriesProgress), 'color' => 'blue'],
            ['label' => 'Water', 'progress' => round($waterProgress), 'color' => 'blue'],
        ];
    }

    /**
     * Get current streak.
     */
    private function getCurrentStreak($userId)
    {
        $streak = 0;
        $date = Carbon::today();
        
        while (true) {
            $hasActivity = UserExerciseProgress::where('user_id', $userId)
                ->whereDate('completed_at', $date)
                ->exists();
                
            if (!$hasActivity) {
                break;
            }
            
            $streak++;
            $date->subDay();
        }
        
        return $streak;
    }

    /**
     * Get motivational quote.
     */
    private function getMotivationalQuote()
    {
        $quotes = [
            ['text' => 'The only bad workout is the one that didn\'t happen.', 'author' => 'Unknown'],
            ['text' => 'Success starts with self-discipline.', 'author' => 'Unknown'],
            ['text' => 'Your body can stand almost anything. It\'s your mind you have to convince.', 'author' => 'Unknown'],
            ['text' => 'The pain you feel today will be the strength you feel tomorrow.', 'author' => 'Unknown'],
            ['text' => 'Progress is not about perfection, it\'s about consistency.', 'author' => 'Unknown'],
            ['text' => 'Every workout brings you one step closer to your goals.', 'author' => 'Unknown'],
            ['text' => 'Fitness is not about being better than someone else. It\'s about being better than you used to be.', 'author' => 'Unknown'],
            ['text' => 'The secret to getting ahead is getting started.', 'author' => 'Mark Twain'],
        ];
        
        return $quotes[array_rand($quotes)];
    }
}