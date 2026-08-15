<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Challenge;
use App\Models\ChallengeDay;
use Illuminate\Support\Facades\DB;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ChallengeDay::truncate();
        Challenge::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Create the 30-Day Beginner Plan
        $challenge = Challenge::create([
            'name' => '30-Day Beginner Fitness Plan',
            'description' => 'A comprehensive 30-day plan designed for beginners. Each day focuses on different muscle groups with proper rest days.',
            'difficulty' => 'Beginner',
            'duration' => 30,
            'image_url' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400&h=300&fit=crop&auto=format',
            'color' => 'emerald',
            'is_featured' => true,
            'requirements' => [
                'Complete the daily workout',
                'Log your progress',
                'Stay consistent',
                'Take rest days seriously'
            ],
            'rewards' => [
                '🏆 Completion Certificate',
                '💪 Strength Foundation',
                '🎯 Habit Achievement',
                '🔥 30-Day Streak Badge'
            ],
        ]);

        // Define the 30-day plan
        $plan = $this->getBeginnerPlan();

        foreach ($plan as $dayData) {
            ChallengeDay::create([
                'challenge_id' => $challenge->id,
                'day_number' => $dayData['day'],
                'workout_name' => $dayData['workout_name'],
                'exercises' => $dayData['exercises'],
                'sets' => $dayData['sets'],
                'reps' => $dayData['reps'],
                'estimated_calories' => $dayData['calories'],
                'estimated_duration' => $dayData['duration'],
                'notes' => $dayData['notes'] ?? null,
            ]);
        }

        $this->command->info('✅ 30-Day Beginner Plan created successfully!');
        $this->command->info('📊 Total days: ' . ChallengeDay::count());
    }

    private function getBeginnerPlan()
    {
        return [
            // Week 1 - Building Foundation
            [
                'day' => 1,
                'workout_name' => 'Full Body Introduction',
                'exercises' => [
                    ['name' => 'Bodyweight Squats', 'sets' => 3, 'reps' => '10-12'],
                    ['name' => 'Wall Push-ups', 'sets' => 3, 'reps' => '8-10'],
                    ['name' => 'Glute Bridges', 'sets' => 3, 'reps' => '12-15'],
                    ['name' => 'Plank (knee supported)', 'sets' => 3, 'reps' => '20 seconds'],
                    ['name' => 'Bird Dogs', 'sets' => 3, 'reps' => '10 each side'],
                ],
                'sets' => 3,
                'reps' => '10-15',
                'calories' => 120,
                'duration' => 20,
                'notes' => 'Focus on form over speed. Take breaks as needed.',
            ],
            [
                'day' => 2,
                'workout_name' => 'Upper Body Focus',
                'exercises' => [
                    ['name' => 'Wall Push-ups', 'sets' => 3, 'reps' => '10-12'],
                    ['name' => 'Dumbbell Rows (light)', 'sets' => 3, 'reps' => '10 each arm'],
                    ['name' => 'Overhead Press (light)', 'sets' => 3, 'reps' => '8-10'],
                    ['name' => 'Bicep Curls (light)', 'sets' => 3, 'reps' => '10-12'],
                    ['name' => 'Tricep Dips (chair)', 'sets' => 3, 'reps' => '8-10'],
                ],
                'sets' => 3,
                'reps' => '8-12',
                'calories' => 130,
                'duration' => 25,
                'notes' => 'Use light weights or water bottles if no dumbbells.',
            ],
            [
                'day' => 3,
                'workout_name' => 'Lower Body & Core',
                'exercises' => [
                    ['name' => 'Bodyweight Squats', 'sets' => 3, 'reps' => '12-15'],
                    ['name' => 'Forward Lunges', 'sets' => 3, 'reps' => '10 each leg'],
                    ['name' => 'Glute Bridges', 'sets' => 3, 'reps' => '15-20'],
                    ['name' => 'Plank', 'sets' => 3, 'reps' => '25 seconds'],
                    ['name' => 'Leg Raises', 'sets' => 3, 'reps' => '10-12'],
                ],
                'sets' => 3,
                'reps' => '10-15',
                'calories' => 140,
                'duration' => 25,
                'notes' => 'Keep core engaged throughout the workout.',
            ],
            [
                'day' => 4,
                'workout_name' => 'Active Recovery',
                'exercises' => [
                    ['name' => 'Brisk Walking', 'sets' => 1, 'reps' => '20 minutes'],
                    ['name' => 'Full Body Stretching', 'sets' => 1, 'reps' => '10 minutes'],
                    ['name' => 'Deep Breathing', 'sets' => 1, 'reps' => '5 minutes'],
                ],
                'sets' => 1,
                'reps' => 'Various',
                'calories' => 80,
                'duration' => 35,
                'notes' => 'Active recovery day. Focus on mobility and breathing.',
            ],
            [
                'day' => 5,
                'workout_name' => 'Full Body Strength',
                'exercises' => [
                    ['name' => 'Bodyweight Squats', 'sets' => 3, 'reps' => '15-20'],
                    ['name' => 'Push-ups (knee)', 'sets' => 3, 'reps' => '8-10'],
                    ['name' => 'Bent Over Rows (light)', 'sets' => 3, 'reps' => '10-12'],
                    ['name' => 'Glute Bridges', 'sets' => 3, 'reps' => '15-20'],
                    ['name' => 'Plank', 'sets' => 3, 'reps' => '30 seconds'],
                ],
                'sets' => 3,
                'reps' => '10-15',
                'calories' => 150,
                'duration' => 28,
                'notes' => 'Increase intensity by going deeper in squats.',
            ],
            [
                'day' => 6,
                'workout_name' => 'Cardio & Core',
                'exercises' => [
                    ['name' => 'Jumping Jacks', 'sets' => 3, 'reps' => '30 seconds'],
                    ['name' => 'High Knees', 'sets' => 3, 'reps' => '30 seconds'],
                    ['name' => 'Plank', 'sets' => 3, 'reps' => '30 seconds'],
                    ['name' => 'Russian Twists', 'sets' => 3, 'reps' => '10 each side'],
                    ['name' => 'Mountain Climbers', 'sets' => 3, 'reps' => '30 seconds'],
                ],
                'sets' => 3,
                'reps' => '30 sec - 10 reps',
                'calories' => 160,
                'duration' => 25,
                'notes' => 'Go at your own pace. Rest between sets.',
            ],
            [
                'day' => 7,
                'workout_name' => 'Rest & Recovery',
                'exercises' => [
                    ['name' => 'Gentle Stretching', 'sets' => 1, 'reps' => '15 minutes'],
                    ['name' => 'Foam Rolling', 'sets' => 1, 'reps' => '10 minutes'],
                    ['name' => 'Mindful Breathing', 'sets' => 1, 'reps' => '5 minutes'],
                ],
                'sets' => 1,
                'reps' => 'Various',
                'calories' => 50,
                'duration' => 30,
                'notes' => 'Complete rest day. Focus on recovery and mobility.',
            ],

            // Week 2 - Building Confidence
            [
                'day' => 8,
                'workout_name' => 'Upper Body Progression',
                'exercises' => [
                    ['name' => 'Push-ups (knee)', 'sets' => 3, 'reps' => '10-12'],
                    ['name' => 'Dumbbell Rows', 'sets' => 3, 'reps' => '12 each arm'],
                    ['name' => 'Overhead Press', 'sets' => 3, 'reps' => '10-12'],
                    ['name' => 'Bicep Curls', 'sets' => 3, 'reps' => '12-15'],
                    ['name' => 'Tricep Dips', 'sets' => 3, 'reps' => '10-12'],
                ],
                'sets' => 3,
                'reps' => '10-15',
                'calories' => 150,
                'duration' => 28,
                'notes' => 'Increase reps or weight slightly.',
            ],
            [
                'day' => 9,
                'workout_name' => 'Leg Day',
                'exercises' => [
                    ['name' => 'Squats', 'sets' => 3, 'reps' => '15-20'],
                    ['name' => 'Walking Lunges', 'sets' => 3, 'reps' => '10 each leg'],
                    ['name' => 'Glute Bridges', 'sets' => 3, 'reps' => '20-25'],
                    ['name' => 'Calf Raises', 'sets' => 3, 'reps' => '15-20'],
                    ['name' => 'Wall Sit', 'sets' => 3, 'reps' => '30 seconds'],
                ],
                'sets' => 3,
                'reps' => '15-20',
                'calories' => 160,
                'duration' => 28,
                'notes' => 'Focus on keeping chest up during squats.',
            ],
            [
                'day' => 10,
                'workout_name' => 'Full Body Circuit',
                'exercises' => [
                    ['name' => 'Jumping Jacks', 'sets' => 3, 'reps' => '45 seconds'],
                    ['name' => 'Push-ups', 'sets' => 3, 'reps' => '10-12'],
                    ['name' => 'Squats', 'sets' => 3, 'reps' => '15-20'],
                    ['name' => 'Plank', 'sets' => 3, 'reps' => '30-45 seconds'],
                    ['name' => 'Superman', 'sets' => 3, 'reps' => '12-15'],
                ],
                'sets' => 3,
                'reps' => '10-20',
                'calories' => 170,
                'duration' => 30,
                'notes' => 'Move quickly between exercises for cardio benefit.',
            ],
            [
                'day' => 11,
                'workout_name' => 'Active Recovery',
                'exercises' => [
                    ['name' => 'Brisk Walking', 'sets' => 1, 'reps' => '25 minutes'],
                    ['name' => 'Yoga Stretching', 'sets' => 1, 'reps' => '10 minutes'],
                    ['name' => 'Deep Breathing', 'sets' => 1, 'reps' => '5 minutes'],
                ],
                'sets' => 1,
                'reps' => 'Various',
                'calories' => 90,
                'duration' => 40,
                'notes' => 'Light recovery day. Listen to your body.',
            ],
            [
                'day' => 12,
                'workout_name' => 'Upper Body & Core',
                'exercises' => [
                    ['name' => 'Diamond Push-ups', 'sets' => 3, 'reps' => '8-10'],
                    ['name' => 'Pike Push-ups', 'sets' => 3, 'reps' => '8-10'],
                    ['name' => 'Russian Twists', 'sets' => 3, 'reps' => '15 each side'],
                    ['name' => 'Leg Raises', 'sets' => 3, 'reps' => '15-20'],
                    ['name' => 'Mountain Climbers', 'sets' => 3, 'reps' => '30 seconds'],
                ],
                'sets' => 3,
                'reps' => '8-15',
                'calories' => 155,
                'duration' => 28,
                'notes' => 'Challenge yourself with different push-up variations.',
            ],
            [
                'day' => 13,
                'workout_name' => 'Lower Body Power',
                'exercises' => [
                    ['name' => 'Sumo Squats', 'sets' => 3, 'reps' => '15-20'],
                    ['name' => 'Lunges with Pulse', 'sets' => 3, 'reps' => '12 each leg'],
                    ['name' => 'Glute Bridges (single leg)', 'sets' => 3, 'reps' => '10 each'],
                    ['name' => 'Side Lunges', 'sets' => 3, 'reps' => '10 each side'],
                    ['name' => 'Calf Raises', 'sets' => 3, 'reps' => '20-25'],
                ],
                'sets' => 3,
                'reps' => '10-25',
                'calories' => 170,
                'duration' => 30,
                'notes' => 'Focus on stability and balance.',
            ],
            [
                'day' => 14,
                'workout_name' => 'Rest & Stretch',
                'exercises' => [
                    ['name' => 'Full Body Stretching', 'sets' => 1, 'reps' => '20 minutes'],
                    ['name' => 'Foam Rolling', 'sets' => 1, 'reps' => '10 minutes'],
                    ['name' => 'Meditation', 'sets' => 1, 'reps' => '10 minutes'],
                ],
                'sets' => 1,
                'reps' => 'Various',
                'calories' => 50,
                'duration' => 40,
                'notes' => 'Rest and reflect on your progress so far.',
            ],

            // Week 3 - Building Strength
            [
                'day' => 15,
                'workout_name' => 'Strength Builder',
                'exercises' => [
                    ['name' => 'Regular Push-ups', 'sets' => 3, 'reps' => '10-12'],
                    ['name' => 'Squats with Hold', 'sets' => 3, 'reps' => '15 with 3 sec hold'],
                    ['name' => 'Renegade Rows', 'sets' => 3, 'reps' => '10 each arm'],
                    ['name' => 'Plank to Downward Dog', 'sets' => 3, 'reps' => '10-12'],
                    ['name' => 'Pistol Squats (assisted)', 'sets' => 3, 'reps' => '8 each leg'],
                ],
                'sets' => 3,
                'reps' => '8-15',
                'calories' => 180,
                'duration' => 32,
                'notes' => 'Focus on controlled movements.',
            ],
            [
                'day' => 16,
                'workout_name' => 'Upper Body Challenge',
                'exercises' => [
                    ['name' => 'Diamond Push-ups', 'sets' => 3, 'reps' => '10-12'],
                    ['name' => 'Wide Push-ups', 'sets' => 3, 'reps' => '10-12'],
                    ['name' => 'Tricep Dips (elevated)', 'sets' => 3, 'reps' => '12-15'],
                    ['name' => 'Bicep Curls (with resistance)', 'sets' => 3, 'reps' => '12-15'],
                    ['name' => 'Shoulder Taps', 'sets' => 3, 'reps' => '20-30'],
                ],
                'sets' => 3,
                'reps' => '10-30',
                'calories' => 175,
                'duration' => 30,
                'notes' => 'Try different push-up variations.',
            ],
            [
                'day' => 17,
                'workout_name' => 'Leg Day Intense',
                'exercises' => [
                    ['name' => 'Bulgarian Split Squats', 'sets' => 3, 'reps' => '10 each leg'],
                    ['name' => 'Jump Squats', 'sets' => 3, 'reps' => '12-15'],
                    ['name' => 'Lunges with Jump', 'sets' => 3, 'reps' => '10 each leg'],
                    ['name' => 'Glute Bridges (weighted)', 'sets' => 3, 'reps' => '20-25'],
                    ['name' => 'Step-ups', 'sets' => 3, 'reps' => '12 each leg'],
                ],
                'sets' => 3,
                'reps' => '10-25',
                'calories' => 190,
                'duration' => 33,
                'notes' => 'Add intensity with explosive movements.',
            ],
            [
                'day' => 18,
                'workout_name' => 'Active Recovery',
                'exercises' => [
                    ['name' => 'Light Jogging', 'sets' => 1, 'reps' => '20 minutes'],
                    ['name' => 'Dynamic Stretching', 'sets' => 1, 'reps' => '10 minutes'],
                    ['name' => 'Breathing Exercises', 'sets' => 1, 'reps' => '5 minutes'],
                ],
                'sets' => 1,
                'reps' => 'Various',
                'calories' => 100,
                'duration' => 35,
                'notes' => 'Active recovery. Keep moving but don\'t push hard.',
            ],
            [
                'day' => 19,
                'workout_name' => 'Full Body Blast',
                'exercises' => [
                    ['name' => 'Burpees (modified)', 'sets' => 3, 'reps' => '10-12'],
                    ['name' => 'Mountain Climbers', 'sets' => 3, 'reps' => '45 seconds'],
                    ['name' => 'Squat to Press (with weight)', 'sets' => 3, 'reps' => '12-15'],
                    ['name' => 'Renegade Rows', 'sets' => 3, 'reps' => '10 each arm'],
                    ['name' => 'Plank Jacks', 'sets' => 3, 'reps' => '20-30'],
                ],
                'sets' => 3,
                'reps' => '10-45 sec',
                'calories' => 200,
                'duration' => 35,
                'notes' => 'High energy workout. Give it your all!',
            ],
            [
                'day' => 20,
                'workout_name' => 'Core & Cardio',
                'exercises' => [
                    ['name' => 'Russian Twists (weighted)', 'sets' => 3, 'reps' => '20 each side'],
                    ['name' => 'Leg Raises', 'sets' => 3, 'reps' => '20-25'],
                    ['name' => 'Bicycle Crunches', 'sets' => 3, 'reps' => '20 each side'],
                    ['name' => 'Plank (full)', 'sets' => 3, 'reps' => '45-60 seconds'],
                    ['name' => 'Jackknife', 'sets' => 3, 'reps' => '15-20'],
                ],
                'sets' => 3,
                'reps' => '15-30',
                'calories' => 180,
                'duration' => 30,
                'notes' => 'Core strength is key for overall fitness.',
            ],
            [
                'day' => 21,
                'workout_name' => 'Rest & Recovery',
                'exercises' => [
                    ['name' => 'Deep Stretching', 'sets' => 1, 'reps' => '20 minutes'],
                    ['name' => 'Foam Rolling', 'sets' => 1, 'reps' => '15 minutes'],
                    ['name' => 'Guided Meditation', 'sets' => 1, 'reps' => '10 minutes'],
                ],
                'sets' => 1,
                'reps' => 'Various',
                'calories' => 60,
                'duration' => 45,
                'notes' => 'You\'re 2/3 done! Rest and recover.',
            ],

            // Week 4 - Final Push
            [
                'day' => 22,
                'workout_name' => 'Advanced Full Body',
                'exercises' => [
                    ['name' => 'Full Push-ups', 'sets' => 4, 'reps' => '12-15'],
                    ['name' => 'Squats (weighted)', 'sets' => 4, 'reps' => '20-25'],
                    ['name' => 'Dumbbell Rows', 'sets' => 4, 'reps' => '15 each arm'],
                    ['name' => 'Glute Bridges (weighted)', 'sets' => 4, 'reps' => '25-30'],
                    ['name' => 'Plank (full)', 'sets' => 4, 'reps' => '60 seconds'],
                ],
                'sets' => 4,
                'reps' => '12-30',
                'calories' => 220,
                'duration' => 38,
                'notes' => 'Increase intensity for the final week!',
            ],
            [
                'day' => 23,
                'workout_name' => 'Upper Body Max',
                'exercises' => [
                    ['name' => 'Diamond Push-ups', 'sets' => 4, 'reps' => '12-15'],
                    ['name' => 'Wide Push-ups', 'sets' => 4, 'reps' => '12-15'],
                    ['name' => 'Tricep Dips (with weight)', 'sets' => 4, 'reps' => '15-20'],
                    ['name' => 'Bicep Curls (heavier)', 'sets' => 4, 'reps' => '15-20'],
                    ['name' => 'Handstand Push-ups (wall)', 'sets' => 4, 'reps' => '8-10'],
                ],
                'sets' => 4,
                'reps' => '8-20',
                'calories' => 200,
                'duration' => 35,
                'notes' => 'Push your upper body strength to the max!',
            ],
            [
                'day' => 24,
                'workout_name' => 'Leg Day Extreme',
                'exercises' => [
                    ['name' => 'Pistol Squats', 'sets' => 4, 'reps' => '10 each leg'],
                    ['name' => 'Jump Squats', 'sets' => 4, 'reps' => '20-25'],
                    ['name' => 'Bulgarian Split Squats', 'sets' => 4, 'reps' => '15 each leg'],
                    ['name' => 'Glute Bridges (weighted)', 'sets' => 4, 'reps' => '30-35'],
                    ['name' => 'Calf Raises (weighted)', 'sets' => 4, 'reps' => '30-40'],
                ],
                'sets' => 4,
                'reps' => '10-40',
                'calories' => 230,
                'duration' => 40,
                'notes' => 'Final leg day! Go hard!',
            ],
            [
                'day' => 25,
                'workout_name' => 'Active Recovery',
                'exercises' => [
                    ['name' => 'Walking (uphill)', 'sets' => 1, 'reps' => '30 minutes'],
                    ['name' => 'Yoga Stretching', 'sets' => 1, 'reps' => '15 minutes'],
                    ['name' => 'Breathing Exercises', 'sets' => 1, 'reps' => '10 minutes'],
                ],
                'sets' => 1,
                'reps' => 'Various',
                'calories' => 120,
                'duration' => 55,
                'notes' => 'Active recovery. Keep moving.',
            ],
            [
                'day' => 26,
                'workout_name' => 'Full Body Finisher',
                'exercises' => [
                    ['name' => 'Burpees (full)', 'sets' => 4, 'reps' => '15-20'],
                    ['name' => 'Push-ups to Squats', 'sets' => 4, 'reps' => '15-20'],
                    ['name' => 'Mountain Climbers', 'sets' => 4, 'reps' => '60 seconds'],
                    ['name' => 'Plank', 'sets' => 4, 'reps' => '75 seconds'],
                    ['name' => 'Jump Lunges', 'sets' => 4, 'reps' => '15 each leg'],
                ],
                'sets' => 4,
                'reps' => '15-20',
                'calories' => 250,
                'duration' => 42,
                'notes' => 'Final push! Give it everything you\'ve got!',
            ],
            [
                'day' => 27,
                'workout_name' => 'Core Strength Finale',
                'exercises' => [
                    ['name' => 'Weighted Russian Twists', 'sets' => 4, 'reps' => '25 each side'],
                    ['name' => 'Hanging Leg Raises', 'sets' => 4, 'reps' => '20-25'],
                    ['name' => 'Bicycle Crunches', 'sets' => 4, 'reps' => '30 each side'],
                    ['name' => 'Plank', 'sets' => 4, 'reps' => '90 seconds'],
                    ['name' => 'Dragon Flags (modified)', 'sets' => 4, 'reps' => '12-15'],
                ],
                'sets' => 4,
                'reps' => '12-30',
                'calories' => 210,
                'duration' => 35,
                'notes' => 'Strong core = strong body!',
            ],
            [
                'day' => 28,
                'workout_name' => 'Rest & Recovery',
                'exercises' => [
                    ['name' => 'Light Stretching', 'sets' => 1, 'reps' => '20 minutes'],
                    ['name' => 'Foam Rolling', 'sets' => 1, 'reps' => '15 minutes'],
                    ['name' => 'Reflection & Goal Setting', 'sets' => 1, 'reps' => '15 minutes'],
                ],
                'sets' => 1,
                'reps' => 'Various',
                'calories' => 50,
                'duration' => 50,
                'notes' => 'Celebrate your progress!',
            ],
            [
                'day' => 29,
                'workout_name' => 'Final Full Body',
                'exercises' => [
                    ['name' => 'Push-ups (all variations)', 'sets' => 4, 'reps' => '15-20'],
                    ['name' => 'Squats (weighted)', 'sets' => 4, 'reps' => '25-30'],
                    ['name' => 'Dumbbell Rows', 'sets' => 4, 'reps' => '20 each arm'],
                    ['name' => 'Glute Bridges (weighted)', 'sets' => 4, 'reps' => '35-40'],
                    ['name' => 'Plank', 'sets' => 4, 'reps' => '90 seconds'],
                ],
                'sets' => 4,
                'reps' => '15-40',
                'calories' => 260,
                'duration' => 45,
                'notes' => 'Final full workout! You\'re almost there!',
            ],
            [
                'day' => 30,
                'workout_name' => 'Graduation Day!',
                'exercises' => [
                    ['name' => 'All exercises from Day 1 (increased reps)', 'sets' => 3, 'reps' => '20-25'],
                    ['name' => 'Reflect on your journey', 'sets' => 1, 'reps' => '1 achievement'],
                    ['name' => 'Celebrate your progress!', 'sets' => 1, 'reps' => '1 celebration'],
                ],
                'sets' => 3,
                'reps' => '20-25',
                'calories' => 200,
                'duration' => 30,
                'notes' => '🎉 Congratulations! You completed the 30-Day Beginner Plan! 🎉',
            ],
        ];
    }
}

// Add after the 30-Day Beginner Plan creation

// Create Push-Up Challenge
$pushUpChallenge = Challenge::create([
    'name' => '30-Day Push-Up Challenge',
    'description' => 'Build upper body strength with daily push-up progressions. Start from knee push-ups and work your way up!',
    'difficulty' => 'Intermediate',
    'duration' => 30,
    'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=300&fit=crop&auto=format',
    'color' => 'blue',
    'is_featured' => false,
    'requirements' => [
        'Complete daily push-ups',
        'Track your progress',
        'Focus on proper form'
    ],
    'rewards' => [
        '💪 Upper Body Master',
        '🔥 Strength Badge',
        '📈 Progression Certificate'
    ],
]);

// Add push-up days
for ($i = 1; $i <= 30; $i++) {
    $reps = min($i * 2, 100);
    ChallengeDay::create([
        'challenge_id' => $pushUpChallenge->id,
        'day_number' => $i,
        'workout_name' => "Push-Up Day {$i}",
        'exercises' => [
            ['name' => 'Standard Push-ups', 'sets' => 3, 'reps' => $reps],
            ['name' => 'Tricep Push-ups', 'sets' => 2, 'reps' => round($reps * 0.7)],
            ['name' => 'Wide Push-ups', 'sets' => 2, 'reps' => round($reps * 0.7)],
        ],
        'sets' => 3,
        'reps' => $reps,
        'estimated_calories' => rand(100, 200),
        'estimated_duration' => rand(15, 25),
        'notes' => "Day {$i}: Complete {$reps} push-ups total",
    ]);
}