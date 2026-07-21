<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        $exercises = [
            [
                'name' => 'Bench Press',
                'description' => 'A compound exercise targeting the chest, shoulders, and triceps.',
                'body_part' => 'Chest',
                'difficulty' => 'Intermediate',
                'equipment' => ['Barbell', 'Bench'],
                'muscle_groups' => ['Pectorals', 'Triceps', 'Deltoids'],
                'instructions' => [
                    'Lie on the bench with your eyes under the bar',
                    'Grip the bar slightly wider than shoulder-width',
                    'Unrack the bar and lower it to your chest',
                    'Press the bar back up to starting position'
                ],
                'calories_per_hour' => 400,
                'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=300&fit=crop&auto=format',
                'is_active' => true
            ],
            [
                'name' => 'Deadlift',
                'description' => 'A compound exercise that works your entire posterior chain.',
                'body_part' => 'Back',
                'difficulty' => 'Advanced',
                'equipment' => ['Barbell'],
                'muscle_groups' => ['Hamstrings', 'Glutes', 'Back', 'Core'],
                'instructions' => [
                    'Stand with feet hip-width apart over the bar',
                    'Bend at the hips and grip the bar',
                    'Keep your back straight and lift the bar',
                    'Return to starting position with control'
                ],
                'calories_per_hour' => 450,
                'image_url' => 'https://images.unsplash.com/photo-1534367610401-9f5ed68180aa?w=400&h=300&fit=crop&auto=format',
                'is_active' => true
            ],
            [
                'name' => 'Squat',
                'description' => 'The king of leg exercises, building strength and muscle.',
                'body_part' => 'Legs',
                'difficulty' => 'Intermediate',
                'equipment' => ['Barbell', 'Squat Rack'],
                'muscle_groups' => ['Quadriceps', 'Hamstrings', 'Glutes', 'Core'],
                'instructions' => [
                    'Position the bar on your upper back',
                    'Stand with feet shoulder-width apart',
                    'Lower your hips down and back',
                    'Drive through your heels to stand up'
                ],
                'calories_per_hour' => 500,
                'image_url' => 'https://images.unsplash.com/photo-1570824104453-508955ab713e?w=400&h=300&fit=crop&auto=format',
                'is_active' => true
            ],
            [
                'name' => 'Pull-up',
                'description' => 'An upper body compound exercise for back and biceps.',
                'body_part' => 'Back',
                'difficulty' => 'Advanced',
                'equipment' => ['Pull-up Bar'],
                'muscle_groups' => ['Latissimus Dorsi', 'Biceps', 'Core'],
                'instructions' => [
                    'Hang from the bar with an overhand grip',
                    'Pull yourself up until your chin passes the bar',
                    'Lower yourself back down with control'
                ],
                'calories_per_hour' => 350,
                'image_url' => 'https://images.unsplash.com/photo-1594381898411-846e7d193883?w=400&h=300&fit=crop&auto=format',
                'is_active' => true
            ],
            [
                'name' => 'Shoulder Press',
                'description' => 'Build strong shoulders and upper body strength.',
                'body_part' => 'Shoulders',
                'difficulty' => 'Intermediate',
                'equipment' => ['Dumbbells', 'Bench'],
                'muscle_groups' => ['Deltoids', 'Triceps', 'Upper Chest'],
                'instructions' => [
                    'Sit on a bench with dumbbells at shoulder height',
                    'Press the weights overhead',
                    'Lower back to starting position with control'
                ],
                'calories_per_hour' => 350,
                'image_url' => 'https://images.unsplash.com/photo-1581009146145-b5ef050c2e1e?w=400&h=300&fit=crop&auto=format',
                'is_active' => true
            ],
            [
                'name' => 'Plank',
                'description' => 'A core exercise that builds stability and strength.',
                'body_part' => 'Core',
                'difficulty' => 'Beginner',
                'equipment' => ['Bodyweight'],
                'muscle_groups' => ['Abdominals', 'Core', 'Shoulders'],
                'instructions' => [
                    'Start in a push-up position',
                    'Keep your body in a straight line',
                    'Hold the position for time'
                ],
                'calories_per_hour' => 200,
                'image_url' => 'https://images.unsplash.com/photo-1566241440091-ec10de8c1e2d?w=400&h=300&fit=crop&auto=format',
                'is_active' => true
            ],
        ];

        foreach ($exercises as $exercise) {
            Exercise::create($exercise);
        }
    }
}