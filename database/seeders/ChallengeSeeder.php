<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Challenge;
use App\Models\ChallengeDay;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        Challenge::truncate();
        ChallengeDay::truncate();

        $challenges = [
            [
                'name' => '30-Day Beginner Plan',
                'description' => 'Perfect for beginners starting their fitness journey. Build habits and gain confidence.',
                'difficulty' => 'Beginner',
                'duration' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400&h=300&fit=crop&auto=format',
                'color' => 'emerald',
                'is_featured' => true,
                'requirements' => ['Complete daily workout', 'Log your progress', 'Stay consistent'],
                'rewards' => ['🏆 Completion Badge', '💪 Strength Certificate', '🎯 Goal Achievement'],
            ],
            [
                'name' => 'Push-Up Challenge',
                'description' => 'Build upper body strength with daily push-up progressions.',
                'difficulty' => 'Intermediate',
                'duration' => 21,
                'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=300&fit=crop&auto=format',
                'color' => 'blue',
                'is_featured' => false,
                'requirements' => ['Complete push-ups daily', 'Track your reps', 'Focus on form'],
                'rewards' => ['💪 Upper Body Master', '🔥 Strength Badge', '📈 Progression Certificate'],
            ],
            [
                'name' => '10K Steps Daily',
                'description' => 'Stay active with a goal of 10,000 steps every day for 30 days.',
                'difficulty' => 'Beginner',
                'duration' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?w=400&h=300&fit=crop&auto=format',
                'color' => 'emerald',
                'is_featured' => false,
                'requirements' => ['Walk 10,000 steps daily', 'Use a step tracker', 'Stay consistent'],
                'rewards' => ['🚶 Walking Master', '🌿 Consistency Badge', '🏅 10K Achievement'],
            ],
        ];

        foreach ($challenges as $challengeData) {
            $challenge = Challenge::create($challengeData);
            
            // Create days for the challenge
            for ($i = 1; $i <= $challenge->duration; $i++) {
                $exercises = $this->getExercisesForDay($i, $challenge->name);
                ChallengeDay::create([
                    'challenge_id' => $challenge->id,
                    'day_number' => $i,
                    'workout_name' => $exercises['workout_name'],
                    'exercises' => $exercises['exercises'],
                    'sets' => 3,
                    'reps' => $i <= 15 ? '10-12' : '12-15',
                    'estimated_calories' => rand(100, 250),
                    'estimated_duration' => rand(15, 45),
                    'notes' => $i % 7 == 0 ? 'Rest day - focus on stretching' : null,
                ]);
            }
        }

        $this->command->info('✅ Challenges seeded successfully!');
        $this->command->info('📊 Total challenges: ' . Challenge::count());
    }

    private function getExercisesForDay($day, $challengeName)
    {
        $exercises = [
            ['Push-ups', 'Squats', 'Planks', 'Lunges'],
            ['Pull-ups', 'Deadlifts', 'Squats', 'Bench Press'],
            ['Curls', 'Tricep Dips', 'Shoulder Press', 'Rows'],
            ['Jumping Jacks', 'High Knees', 'Burpees', 'Mountain Climbers'],
            ['Yoga Poses', 'Stretching', 'Breathing', 'Meditation'],
        ];

        $selected = $exercises[array_rand($exercises)];
        
        if ($challengeName == '30-Day Beginner Plan') {
            $selected = ['Push-ups', 'Squats', 'Planks', 'Lunges'];
        } elseif ($challengeName == 'Push-Up Challenge') {
            $count = min($day * 2, 100);
            $selected = ["Push-ups ($count reps)", 'Tricep Dips', 'Shoulder Press'];
        } elseif ($challengeName == '10K Steps Daily') {
            $selected = ['Walking', 'Light Stretching', 'Walking'];
        }

        return [
            'workout_name' => $selected[0] . ' Workout',
            'exercises' => $selected,
        ];
    }
}