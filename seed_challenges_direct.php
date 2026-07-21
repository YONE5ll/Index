<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== Seeding Challenges ===\n\n";

// Disable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS=0');

// Clear tables
Schema::dropIfExists('user_challenge_day_progress');
Schema::dropIfExists('user_challenge_progress');
Schema::dropIfExists('challenge_days');
Schema::dropIfExists('challenges');

echo "✅ Tables cleared\n";

// Create challenges table
Schema::create('challenges', function($table) {
    $table->id();
    $table->string('name');
    $table->text('description');
    $table->string('difficulty');
    $table->integer('duration');
    $table->integer('participants')->default(0);
    $table->string('image_url')->nullable();
    $table->string('color')->default('emerald');
    $table->boolean('is_featured')->default(false);
    $table->boolean('is_active')->default(true);
    $table->json('requirements')->nullable();
    $table->json('rewards')->nullable();
    $table->timestamps();
});

// Insert challenges
DB::table('challenges')->insert([
    [
        'name' => '30-Day Beginner Plan',
        'description' => 'Perfect for beginners starting their fitness journey. Build habits and gain confidence.',
        'difficulty' => 'Beginner',
        'duration' => 30,
        'image_url' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400&h=300&fit=crop&auto=format',
        'color' => 'emerald',
        'is_featured' => 1,
        'is_active' => 1,
        'requirements' => '["Complete daily workout", "Log your progress", "Stay consistent"]',
        'rewards' => '["🏆 Completion Badge", "💪 Strength Certificate", "🎯 Goal Achievement"]',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Push-Up Challenge',
        'description' => 'Build upper body strength with daily push-up progressions.',
        'difficulty' => 'Intermediate',
        'duration' => 21,
        'image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=300&fit=crop&auto=format',
        'color' => 'blue',
        'is_featured' => 0,
        'is_active' => 1,
        'requirements' => '["Complete push-ups daily", "Track your reps", "Focus on form"]',
        'rewards' => '["💪 Upper Body Master", "🔥 Strength Badge", "📈 Progression Certificate"]',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => '10K Steps Daily',
        'description' => 'Stay active with a goal of 10,000 steps every day for 30 days.',
        'difficulty' => 'Beginner',
        'duration' => 30,
        'image_url' => 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?w=400&h=300&fit=crop&auto=format',
        'color' => 'emerald',
        'is_featured' => 0,
        'is_active' => 1,
        'requirements' => '["Walk 10,000 steps daily", "Use a step tracker", "Stay consistent"]',
        'rewards' => '["🚶 Walking Master", "🌿 Consistency Badge", "🏅 10K Achievement"]',
        'created_at' => now(),
        'updated_at' => now(),
    ],
]);

// Create challenge_days table
Schema::create('challenge_days', function($table) {
    $table->id();
    $table->foreignId('challenge_id')->constrained('challenges')->onDelete('cascade');
    $table->integer('day_number');
    $table->string('workout_name');
    $table->json('exercises');
    $table->integer('sets')->default(3);
    $table->string('reps')->default('10-12');
    $table->integer('estimated_calories')->nullable();
    $table->integer('estimated_duration')->nullable();
    $table->text('notes')->nullable();
    $table->timestamps();
    $table->unique(['challenge_id', 'day_number'], 'cd_unique');
});

// Insert challenge days for the first challenge (30-Day Beginner Plan)
$challengeId = DB::table('challenges')->where('name', '30-Day Beginner Plan')->first()->id;

for ($i = 1; $i <= 30; $i++) {
    $exercises = ['Push-ups', 'Squats', 'Planks', 'Lunges'];
    DB::table('challenge_days')->insert([
        'challenge_id' => $challengeId,
        'day_number' => $i,
        'workout_name' => 'Beginner Workout',
        'exercises' => json_encode($exercises),
        'sets' => 3,
        'reps' => $i <= 15 ? '10-12' : '12-15',
        'estimated_calories' => rand(100, 200),
        'estimated_duration' => rand(15, 30),
        'notes' => $i % 7 == 0 ? 'Rest day - focus on stretching' : null,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

// Enable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS=1');

echo "✅ Challenges seeded successfully!\n";
echo "📊 Total challenges: " . DB::table('challenges')->count() . "\n";
echo "📊 Total challenge days: " . DB::table('challenge_days')->count() . "\n";