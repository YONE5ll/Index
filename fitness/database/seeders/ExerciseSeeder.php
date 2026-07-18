<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        // Sample exercises, a few for each muscle group/category
        $exercises = [
            // Chest
            ['name' => 'Bench Press', 'muscle_group' => 'Chest', 'description' => 'Compound lift targeting the chest, shoulders, and triceps.', 'image_path' => 'images/exercises/bench_press.jpg'],
            ['name' => 'Push Up', 'muscle_group' => 'Chest', 'description' => 'Bodyweight exercise for chest and triceps.', 'image_path' => 'images/exercises/push_up.jpg'],

            // Back
            ['name' => 'Deadlift', 'muscle_group' => 'Back', 'description' => 'Full-body pull exercise focusing on the back and posterior chain.', 'image_path' => 'images/exercises/deadlift.jpg'],
            ['name' => 'Lat Pulldown', 'muscle_group' => 'Back', 'description' => 'Machine exercise targeting the lats.', 'image_path' => 'images/exercises/lat_pulldown.jpg'],

            // Shoulders
            ['name' => 'Overhead Press', 'muscle_group' => 'Shoulders', 'description' => 'Compound press targeting the deltoids.', 'image_path' => 'images/exercises/overhead_press.jpg'],
            ['name' => 'Lateral Raise', 'muscle_group' => 'Shoulders', 'description' => 'Isolation exercise for the side deltoids.', 'image_path' => 'images/exercises/lateral_raise.jpg'],

            // Biceps
            ['name' => 'Bicep Curl', 'muscle_group' => 'Biceps', 'description' => 'Isolation exercise for the biceps using dumbbells or a barbell.', 'image_path' => 'images/exercises/bicep_curl.jpg'],
            ['name' => 'Hammer Curl', 'muscle_group' => 'Biceps', 'description' => 'Curl variation targeting biceps and forearms.', 'image_path' => 'images/exercises/hammer_curl.jpg'],

            // Triceps
            ['name' => 'Tricep Dip', 'muscle_group' => 'Triceps', 'description' => 'Bodyweight exercise targeting the triceps.', 'image_path' => 'images/exercises/tricep_dip.jpg'],
            ['name' => 'Tricep Pushdown', 'muscle_group' => 'Triceps', 'description' => 'Cable exercise isolating the triceps.', 'image_path' => 'images/exercises/tricep_pushdown.jpg'],

            // Legs
            ['name' => 'Squat', 'muscle_group' => 'Legs', 'description' => 'Compound lower-body exercise targeting quads, hamstrings, and glutes.', 'image_path' => 'images/exercises/squat.jpg'],
            ['name' => 'Lunges', 'muscle_group' => 'Legs', 'description' => 'Unilateral leg exercise for strength and balance.', 'image_path' => 'images/exercises/lunges.jpg'],

            // Core/Abs
            ['name' => 'Plank', 'muscle_group' => 'Core/Abs', 'description' => 'Isometric core exercise for stability.', 'image_path' => 'images/exercises/plank.jpg'],
            ['name' => 'Crunches', 'muscle_group' => 'Core/Abs', 'description' => 'Basic abdominal exercise.', 'image_path' => 'images/exercises/crunches.jpg'],

            // Cardio
            ['name' => 'Running', 'muscle_group' => 'Cardio', 'description' => 'Cardiovascular exercise to improve endurance.', 'image_path' => 'images/exercises/running.jpg'],
            ['name' => 'Jump Rope', 'muscle_group' => 'Cardio', 'description' => 'High-intensity cardio exercise for full-body conditioning.', 'image_path' => 'images/exercises/jump_rope.jpg'],
        ];

        foreach ($exercises as $exercise) {
            Exercise::create($exercise);
        }
    }
}