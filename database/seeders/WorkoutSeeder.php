<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Workout;
use App\Models\Exercise;

class WorkoutSeeder extends Seeder
{
    public function run(): void
    {
        $workouts = [
            [
                'title' => 'Full Body Strength',
                'description' => 'A complete full body workout focusing on compound movements for maximum strength gains.',
                'category' => 'Strength',
                'difficulty' => 'Intermediate',
                'duration' => 45,
                'calories_burned' => 320,
                'target_muscles' => ['Chest', 'Back', 'Legs', 'Shoulders', 'Core'],
                'equipment' => ['Barbell', 'Dumbbells', 'Bench', 'Pull-up Bar'],
                'instructions' => [
                    'Warm up with 5-10 minutes of light cardio',
                    'Perform each exercise with proper form',
                    'Rest 60-90 seconds between sets',
                    'Cool down with static stretching'
                ],
                'image_url' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400&h=300&fit=crop&auto=format',
                'level' => 2,
                'is_featured' => true,
                'is_active' => true,
                'created_by' => 1,
                'exercises' => [
                    ['name' => 'Bench Press', 'sets' => 4, 'reps' => '8-12', 'rest' => 60, 'order' => 1],
                    ['name' => 'Squat', 'sets' => 4, 'reps' => '8-12', 'rest' => 60, 'order' => 2],
                    ['name' => 'Pull-up', 'sets' => 3, 'reps' => '8-12', 'rest' => 45, 'order' => 3],
                    ['name' => 'Deadlift', 'sets' => 3, 'reps' => '5-8', 'rest' => 90, 'order' => 4],
                ]
            ],
            [
                'title' => 'HIIT Cardio Blast',
                'description' => 'High-intensity interval training to maximize calorie burn and cardiovascular fitness.',
                'category' => 'HIIT',
                'difficulty' => 'Advanced',
                'duration' => 30,
                'calories_burned' => 450,
                'target_muscles' => ['Full Body', 'Cardio', 'Core'],
                'equipment' => ['Bodyweight', 'Timer'],
                'instructions' => [
                    'Perform each exercise for 45 seconds',
                    'Rest 15 seconds between exercises',
                    'Complete 3 rounds',
                    'Do a light cool-down after'
                ],
                'image_url' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=400&h=300&fit=crop&auto=format',
                'level' => 3,
                'is_featured' => false,
                'is_active' => true,
                'created_by' => 1,
                'exercises' => [
                    ['name' => 'Plank', 'sets' => 3, 'reps' => '45 sec', 'rest' => 15, 'order' => 1],
                    ['name' => 'Squat', 'sets' => 3, 'reps' => '45 sec', 'rest' => 15, 'order' => 2],
                    ['name' => 'Shoulder Press', 'sets' => 3, 'reps' => '45 sec', 'rest' => 15, 'order' => 3],
                ]
            ],
            [
                'title' => 'Yoga Flow',
                'description' => 'A gentle yoga sequence to improve flexibility, balance, and mental clarity.',
                'category' => 'Yoga',
                'difficulty' => 'Beginner',
                'duration' => 60,
                'calories_burned' => 200,
                'target_muscles' => ['Core', 'Flexibility', 'Balance', 'Mindfulness'],
                'equipment' => ['Yoga Mat'],
                'instructions' => [
                    'Start with gentle breathing exercises',
                    'Move through each pose mindfully',
                    'Hold each pose for 30-60 seconds',
                    'End with relaxation pose'
                ],
                'image_url' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=400&h=300&fit=crop&auto=format',
                'level' => 1,
                'is_featured' => false,
                'is_active' => true,
                'created_by' => 1,
                'exercises' => [
                    ['name' => 'Plank', 'sets' => 1, 'reps' => '30 sec', 'rest' => 30, 'order' => 1],
                ]
            ],
        ];

        foreach ($workouts as $workoutData) {
            $exercisesData = $workoutData['exercises'] ?? [];
            unset($workoutData['exercises']);
            
            $workout = Workout::create($workoutData);
            
            // Attach exercises to workout
            foreach ($exercisesData as $exerciseData) {
                $exercise = Exercise::where('name', $exerciseData['name'])->first();
                if ($exercise) {
                    $workout->exercises()->attach($exercise->id, [
                        'sets' => $exerciseData['sets'],
                        'reps' => $exerciseData['reps'],
                        'rest_seconds' => $exerciseData['rest'] ?? 60,
                        'order' => $exerciseData['order'] ?? 0,
                    ]);
                }
            }
        }
    }
}