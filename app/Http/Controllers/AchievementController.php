<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * Display the achievements page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $achievements = $this->getAllAchievements();
        $userAchievements = $this->getUserAchievements();
        $stats = $this->getStats();
        
        return view('pages.achievements.index', compact('achievements', 'userAchievements', 'stats'));
    }

    /**
     * Get all achievements.
     *
     * @return array
     */
    private function getAllAchievements()
    {
        return [
            [
                'id' => 1,
                'name' => 'First Workout',
                'description' => 'Complete your first workout',
                'icon' => '🏋️',
                'category' => 'Workout',
                'points' => 50,
                'rarity' => 'common',
                'unlocked' => true
            ],
            [
                'id' => 2,
                'name' => '7-Day Streak',
                'description' => 'Work out for 7 days in a row',
                'icon' => '🔥',
                'category' => 'Consistency',
                'points' => 100,
                'rarity' => 'uncommon',
                'unlocked' => true
            ],
            [
                'id' => 3,
                'name' => '30-Day Streak',
                'description' => 'Work out for 30 days in a row',
                'icon' => '⚡',
                'category' => 'Consistency',
                'points' => 200,
                'rarity' => 'rare',
                'unlocked' => false
            ],
            [
                'id' => 4,
                'name' => 'Weight Loss Milestone',
                'description' => 'Lose 5kg of body weight',
                'icon' => '🎯',
                'category' => 'Progress',
                'points' => 150,
                'rarity' => 'rare',
                'unlocked' => false
            ],
            [
                'id' => 5,
                'name' => 'Strength Master',
                'description' => 'Complete 100 strength training sessions',
                'icon' => '💪',
                'category' => 'Strength',
                'points' => 250,
                'rarity' => 'epic',
                'unlocked' => false
            ],
            [
                'id' => 6,
                'name' => 'Cardio King',
                'description' => 'Burn 10,000 calories through cardio',
                'icon' => '❤️',
                'category' => 'Cardio',
                'points' => 200,
                'rarity' => 'rare',
                'unlocked' => false
            ],
            [
                'id' => 7,
                'name' => 'Early Bird',
                'description' => 'Complete 10 workouts before 7 AM',
                'icon' => '🌅',
                'category' => 'Habits',
                'points' => 100,
                'rarity' => 'uncommon',
                'unlocked' => true
            ],
            [
                'id' => 8,
                'name' => 'Fitness Guru',
                'description' => 'Complete 500 total workouts',
                'icon' => '🌟',
                'category' => 'Milestone',
                'points' => 500,
                'rarity' => 'legendary',
                'unlocked' => false
            ],
        ];
    }

    /**
     * Get user's unlocked achievements.
     *
     * @return array
     */
    private function getUserAchievements()
    {
        return [
            ['id' => 1, 'unlocked_at' => '2024-01-15'],
            ['id' => 2, 'unlocked_at' => '2024-01-22'],
            ['id' => 7, 'unlocked_at' => '2024-02-01'],
        ];
    }

    /**
     * Get achievement statistics.
     *
     * @return array
     */
    private function getStats()
    {
        return [
            'total' => 8,
            'unlocked' => 3,
            'total_points' => 450,
            'next_achievement' => '30-Day Streak',
            'progress_to_next' => 70,
        ];
    }
}