<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Notification;
use App\Http\Controllers\NotificationController;

echo "=== Testing Notifications System ===\n\n";

// Get the first user
$user = User::first();

if (!$user) {
    echo "❌ No user found. Creating a test user...\n";
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);
    echo "✅ Test user created: {$user->name} ({$user->email})\n\n";
} else {
    echo "✅ Using user: {$user->name} ({$user->email})\n\n";
}

// Clear existing notifications
Notification::where('user_id', $user->id)->delete();
echo "🗑️ Cleared existing notifications\n\n";

// Create test notifications
echo "📝 Creating test notifications...\n";

$notifications = [
    [
        'type' => 'workout',
        'title' => '💪 Workout Complete!',
        'message' => 'You finished your HIIT session. Great job! You burned 450 calories.',
        'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
        'color' => 'emerald',
        'action_url' => '/workouts',
        'action_text' => 'View Workout',
        'is_read' => false,
    ],
    [
        'type' => 'achievement',
        'title' => '🏆 New Achievement Unlocked!',
        'message' => 'You earned the "Early Bird" badge for completing 10 workouts before 7 AM.',
        'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
        'color' => 'yellow',
        'action_url' => '/achievements',
        'action_text' => 'View Achievement',
        'is_read' => false,
    ],
    [
        'type' => 'nutrition',
        'title' => '🍗 Nutrition Reminder',
        'message' => "Don't forget to log your dinner. You're on track to meet your daily goals!",
        'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'color' => 'orange',
        'action_url' => '/nutrition',
        'action_text' => 'Log Meal',
        'is_read' => false,
    ],
    [
        'type' => 'community',
        'title' => '👥 New Challenge Available',
        'message' => 'A new 30-day challenge is now available. Join now and push your limits!',
        'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
        'color' => 'emerald',
        'action_url' => '/challenges',
        'action_text' => 'Join Challenge',
        'is_read' => false,
    ],
    [
        'type' => 'reminder',
        'title' => '⏰ Workout Reminder',
        'message' => 'Your workout is scheduled for tomorrow at 7:00 AM. Don\'t forget to prepare!',
        'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        'color' => 'blue',
        'action_url' => '/calendar',
        'action_text' => 'View Schedule',
        'is_read' => false,
    ],
    [
        'type' => 'system',
        'title' => '💧 Water Intake Goal',
        'message' => "You're almost at your daily water goal. Just 0.5L to go!",
        'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
        'color' => 'blue',
        'action_url' => '/nutrition',
        'action_text' => 'Log Water',
        'is_read' => false,
    ],
    [
        'type' => 'system',
        'title' => '🎯 Goal Achievement',
        'message' => 'Congratulations! You\'ve achieved your weekly step goal of 70,000 steps!',
        'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
        'color' => 'purple',
        'action_url' => '/progress',
        'action_text' => 'View Progress',
        'is_read' => true, // Already read
    ],
    [
        'type' => 'workout',
        'title' => '🏋️ New Workout Available',
        'message' => 'A new full-body strength workout has been added to your library.',
        'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
        'color' => 'emerald',
        'action_url' => '/workouts',
        'action_text' => 'View Workouts',
        'is_read' => true, // Already read
    ],
];

foreach ($notifications as $data) {
    Notification::create(array_merge($data, ['user_id' => $user->id]));
    echo "  ✅ Created: {$data['title']}\n";
}

echo "\n📊 Total notifications: " . Notification::where('user_id', $user->id)->count() . "\n";
echo "📊 Unread: " . Notification::where('user_id', $user->id)->where('is_read', false)->count() . "\n";
echo "📊 Read: " . Notification::where('user_id', $user->id)->where('is_read', true)->count() . "\n";

echo "\n✅ Notifications test data created!\n";
echo "\n📱 Visit: http://localhost:8000/notifications\n";
echo "🔑 Login with: test@example.com / password123\n";