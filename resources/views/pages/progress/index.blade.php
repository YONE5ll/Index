@extends('layouts.app')
@extends('layouts.app')

@section('title', 'Progress - FitnessPro')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold">Your Progress</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Track your fitness journey and celebrate your achievements</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $stats = [
                ['label' => 'Workout Streak', 'value' => '15', 'icon' => '🔥', 'color' => 'orange'],
                ['label' => 'Total Workouts', 'value' => '87', 'icon' => '💪', 'color' => 'emerald'],
                ['label' => 'Weight Lost', 'value' => '6.5 kg', 'icon' => '🎯', 'color' => 'blue'],
                ['label' => 'Achievements', 'value' => '8', 'icon' => '🏆', 'color' => 'purple'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
                <div class="text-2xl mb-1">{{ $stat['icon'] }}</div>
                <div class="text-xl font-bold text-{{ $stat['color'] }}-500">{{ $stat['value'] }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Weight Chart -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="font-semibold mb-4">Weight Progress</h3>
            <div class="h-48 flex items-end justify-between space-x-2">
                @php
                    $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'];
                    $values = [82, 81, 79.5, 78, 77, 75.5, 75.5];
                @endphp
                @foreach($labels as $index => $label)
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-blue-500/20 rounded-t-lg transition-all duration-500 hover:bg-blue-500/30"
                             style="height: {{ (90 - $values[$index]) * 2 }}%"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ $label }}</span>
                        <span class="text-xs font-medium">{{ $values[$index] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Body Fat Chart -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="font-semibold mb-4">Body Fat Progress</h3>
            <div class="h-48 flex items-end justify-between space-x-2">
                @php
                    $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'];
                    $values = [22, 21, 20, 19, 18, 16.5, 15.2];
                @endphp
                @foreach($labels as $index => $label)
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full bg-orange-500/20 rounded-t-lg transition-all duration-500 hover:bg-orange-500/30"
                             style="height: {{ (25 - $values[$index]) * 10 }}%"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ $label }}</span>
                        <span class="text-xs font-medium">{{ $values[$index] }}%</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Achievements -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <h3 class="font-semibold mb-4">Recent Achievements</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $achievements = [
                    ['name' => 'First Workout', 'icon' => '🏋️', 'date' => 'Jan 15, 2024'],
                    ['name' => '5-Day Streak', 'icon' => '🔥', 'date' => 'Jan 20, 2024'],
                    ['name' => '10kg Lost', 'icon' => '🎯', 'date' => 'Mar 1, 2024'],
                    ['name' => '100 Workouts', 'icon' => '💪', 'date' => 'Jun 15, 2024'],
                ];
            @endphp
            @foreach($achievements as $achievement)
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <div class="text-3xl mb-2">{{ $achievement['icon'] }}</div>
                    <p class="font-medium text-sm">{{ $achievement['name'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $achievement['date'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Monthly Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h4 class="font-semibold mb-2">Total Workouts</h4>
            <p class="text-3xl font-bold text-emerald-500">22</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">This month</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h4 class="font-semibold mb-2">Calories Burned</h4>
            <p class="text-3xl font-bold text-blue-500">8,500</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">This month</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h4 class="font-semibold mb-2">Best Workout</h4>
            <p class="text-lg font-bold text-orange-500">45 min HIIT</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">450 calories burned</p>
        </div>
    </div>

    <!-- Before/After Photos -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <h3 class="font-semibold mb-4">Progress Photos</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative rounded-xl overflow-hidden">
                <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=400&h=400&fit=crop" 
                     alt="Before" 
                     class="w-full h-64 object-cover">
                <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent">
                    <p class="text-white font-medium">Before</p>
                    <p class="text-white/80 text-sm">January 2024</p>
                </div>
            </div>
            <div class="relative rounded-xl overflow-hidden">
                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400&h=400&fit=crop" 
                     alt="After" 
                     class="w-full h-64 object-cover">
                <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent">
                    <p class="text-white font-medium">After</p>
                    <p class="text-white/80 text-sm">July 2024</p>
                </div>
            </div>
        </div>
        <button class="mt-4 w-full py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-xl transition-colors font-medium">
            Upload New Photos
        </button>
    </div>
</div>
@endsection