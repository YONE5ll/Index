@extends('layouts.app')

@section('title', 'Notifications - FitnessPro')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Notifications</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Stay updated with your fitness journey</p>
        </div>
        <button class="text-sm text-emerald-500 hover:text-emerald-600 transition-colors font-medium">
            Mark all as read
        </button>
    </div>

    <!-- Notification List -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 overflow-hidden">
        @php
            $notifications = [
                [
                    'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                    'color' => 'emerald',
                    'title' => 'Workout Complete!',
                    'message' => 'You finished your HIIT session. Great job!',
                    'time' => '5 min ago',
                    'read' => false,
                    'action' => 'View Workout'
                ],
                [
                    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                    'color' => 'blue',
                    'title' => 'New Achievement Unlocked!',
                    'message' => 'You earned the "Early Bird" badge for completing 10 workouts before 7 AM.',
                    'time' => '1 hour ago',
                    'read' => false,
                    'action' => 'View Achievement'
                ],
                [
                    'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                    'color' => 'orange',
                    'title' => 'Nutrition Reminder',
                    'message' => 'Don\'t forget to log your dinner. You\'re on track to meet your daily goals!',
                    'time' => '3 hours ago',
                    'read' => false,
                    'action' => 'Log Meal'
                ],
                [
                    'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                    'color' => 'emerald',
                    'title' => 'New Challenge Available',
                    'message' => 'A new 30-day challenge is now available. Join now and push your limits!',
                    'time' => 'Yesterday',
                    'read' => true,
                    'action' => 'Join Challenge'
                ],
                [
                    'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                    'color' => 'blue',
                    'title' => 'Workout Reminder',
                    'message' => 'Your workout is scheduled for tomorrow at 7:00 AM. Don\'t forget to prepare!',
                    'time' => 'Yesterday',
                    'read' => true,
                    'action' => 'View Schedule'
                ],
                [
                    'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                    'color' => 'blue',
                    'title' => 'Water Intake Goal',
                    'message' => 'You\'re almost at your daily water goal. Just 0.5L to go!',
                    'time' => '2 days ago',
                    'read' => true,
                    'action' => 'Log Water'
                ],
            ];
        @endphp

        @foreach($notifications as $notification)
            <div class="flex items-start p-4 border-b border-gray-200/50 dark:border-gray-800/50 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors {{ !$notification['read'] ? 'bg-emerald-50/30 dark:bg-emerald-900/5' : '' }}">
                <!-- Icon -->
                <div class="flex-shrink-0 mr-4">
                    <div class="w-10 h-10 rounded-full bg-{{ $notification['color'] }}-500/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-{{ $notification['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $notification['icon'] }}"/>
                        </svg>
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between">
                        <div>
                            <h4 class="font-semibold text-sm">{{ $notification['title'] }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $notification['message'] }}</p>
                            <div class="flex items-center space-x-3 mt-2">
                                <button class="text-xs text-emerald-500 hover:text-emerald-600 transition-colors font-medium">
                                    {{ $notification['action'] }}
                                </button>
                                <span class="text-xs text-gray-400">•</span>
                                <span class="text-xs text-gray-400">{{ $notification['time'] }}</span>
                            </div>
                        </div>
                        @if(!$notification['read'])
                            <span class="flex-shrink-0 w-2 h-2 bg-emerald-500 rounded-full mt-1.5"></span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Load More -->
        <div class="p-4 text-center">
            <button class="text-sm text-gray-500 dark:text-gray-400 hover:text-emerald-500 transition-colors">
                Load more notifications
            </button>
        </div>
    </div>

    <!-- Notification Preferences -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 p-6">
        <h3 class="font-semibold mb-4">Notification Preferences</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                <span class="text-sm">Workout Updates</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                <span class="text-sm">Achievements</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                <span class="text-sm">Community Updates</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-10 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>
        </div>
    </div>
</div>
@endsection