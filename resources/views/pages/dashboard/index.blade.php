@extends('layouts.app')

@section('title', 'Dashboard - Byayam')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-emerald-500/10 via-blue-500/10 to-orange-500/10 dark:from-emerald-500/20 dark:via-blue-500/20 dark:to-orange-500/20 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">Welcome back, {{ $user->name }}! 👋</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Here's your fitness overview for today</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-center px-4 py-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                    <p class="text-sm text-gray-500 dark:text-gray-400">🔥 Streak</p>
                    <p class="text-xl font-bold text-orange-500">{{ $stats['streak'] ?? 0 }} days</p>
                </div>
                <div class="text-center px-4 py-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                    <p class="text-sm text-gray-500 dark:text-gray-400">🏆 Total</p>
                    <p class="text-xl font-bold text-emerald-500">{{ $stats['total_exercises'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
        @php
            $statsCards = [
                ['label' => 'Calories', 'value' => number_format($todayCalories ?? 0), 'target' => '500', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'emerald'],
                ['label' => 'Weight', 'value' => $currentWeight ?? 75.5, 'target' => '72', 'unit' => 'kg', 'icon' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3', 'color' => 'blue'],
                ['label' => 'Water', 'value' => $waterIntake['current'] ?? 1.8, 'target' => $waterIntake['target'] ?? 3, 'unit' => 'L', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'color' => 'blue'],
                ['label' => 'Workout', 'value' => $todayWorkoutTime ?? 0, 'target' => '30', 'unit' => 'min', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'orange'],
                ['label' => 'Steps', 'value' => number_format($steps['current'] ?? 0), 'target' => number_format($steps['target'] ?? 10000), 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'emerald'],
                ['label' => 'Sleep', 'value' => $sleep['current'] ?? 7.5, 'target' => $sleep['target'] ?? 8, 'unit' => 'hrs', 'icon' => 'M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z', 'color' => 'blue'],
                ['label' => 'BMI', 'value' => $bmi ?? 22.4, 'target' => '22', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'color' => 'orange'],
                ['label' => 'Body Fat', 'value' => $bodyFat ?? 15.2, 'target' => '12', 'unit' => '%', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color' => 'emerald'],
            ];
        @endphp

        @foreach($statsCards as $stat)
            @php
                $progress = 0;
                $numericValue = floatval(str_replace(',', '', $stat['value']));
                $numericTarget = floatval(str_replace(',', '', $stat['target']));
                if ($numericTarget > 0) {
                    $progress = min(($numericValue / $numericTarget) * 100, 100);
                }
            @endphp
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</span>
                    <div class="w-7 h-7 rounded-lg bg-{{ $stat['color'] }}-500/10 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-{{ $stat['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                </div>
                <div class="text-lg font-bold">{{ $stat['value'] }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    Target: {{ $stat['target'] }} {{ $stat['unit'] ?? '' }}
                </div>
                <div class="mt-2 h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-{{ $stat['color'] }}-500 to-{{ $stat['color'] }}-400 rounded-full transition-all duration-1000" 
                         style="width: {{ $progress }}%"></div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Calories Chart -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="text-sm font-semibold mb-4">Calories This Week</h3>
            <div class="h-48 w-full relative">
                <div class="absolute inset-0 flex items-end justify-around px-2">
                    @php
                        $maxCalories = max($weeklyCalories['values'] ?? [2000]);
                        if ($maxCalories < 100) $maxCalories = 500;
                    @endphp
                    @foreach($weeklyCalories['days'] ?? [] as $index => $day)
                        @php
                            $value = $weeklyCalories['values'][$index] ?? 0;
                            $percentage = ($value / $maxCalories) * 100;
                            $percentage = min(max($percentage, 5), 100);
                        @endphp
                        <div class="flex flex-col items-center h-full justify-end" style="width: 12%;">
                            <div class="w-full bg-gradient-to-t from-emerald-500/30 to-emerald-500 rounded-t-lg transition-all duration-500 hover:opacity-80 hover:scale-105" 
                                 style="height: {{ $percentage }}%; min-height: 8px;"></div>
                            <span class="text-[10px] text-gray-500 dark:text-gray-400 mt-1">{{ $day }}</span>
                            <span class="text-[9px] font-medium text-gray-600 dark:text-gray-300">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Weight Chart -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="text-sm font-semibold mb-4">Weight Progress</h3>
            <div class="h-48 w-full relative">
                <div class="absolute inset-0 flex items-end justify-around px-2">
                    @php
                        $minWeight = min($weightProgress['values'] ?? [75]);
                        $maxWeight = max($weightProgress['values'] ?? [80]);
                        $range = $maxWeight - $minWeight;
                        if ($range < 1) $range = 5;
                    @endphp
                    @foreach($weightProgress['weeks'] ?? [] as $index => $week)
                        @php
                            $value = $weightProgress['values'][$index] ?? 75;
                            $percentage = (($value - $minWeight) / $range) * 100;
                            $percentage = min(max($percentage, 5), 100);
                        @endphp
                        <div class="flex flex-col items-center h-full justify-end" style="width: 12%;">
                            <div class="w-full bg-gradient-to-t from-blue-500/30 to-blue-500 rounded-t-lg transition-all duration-500 hover:opacity-80 hover:scale-105" 
                                 style="height: {{ $percentage }}%; min-height: 8px;"></div>
                            <span class="text-[10px] text-gray-500 dark:text-gray-400 mt-1">{{ $week }}</span>
                            <span class="text-[9px] font-medium text-gray-600 dark:text-gray-300">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Workout Frequency -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="text-sm font-semibold mb-4">Workout Frequency</h3>
            <div class="h-48 w-full relative">
                <div class="absolute inset-0 flex items-end justify-around px-2">
                    @php
                        $maxWorkouts = max($workoutFrequency['values'] ?? [1]);
                        if ($maxWorkouts < 1) $maxWorkouts = 1;
                    @endphp
                    @foreach($workoutFrequency['days'] ?? [] as $index => $day)
                        @php
                            $value = $workoutFrequency['values'][$index] ?? 0;
                            $percentage = ($value / $maxWorkouts) * 100;
                            $percentage = min(max($percentage, 5), 100);
                        @endphp
                        <div class="flex flex-col items-center h-full justify-end" style="width: 12%;">
                            <div class="w-full bg-gradient-to-t from-orange-500/30 to-orange-500 rounded-t-lg transition-all duration-500 hover:opacity-80 hover:scale-105" 
                                 style="height: {{ $percentage }}%; min-height: 8px;"></div>
                            <span class="text-[10px] text-gray-500 dark:text-gray-400 mt-1">{{ $day }}</span>
                            <span class="text-[9px] font-medium text-gray-600 dark:text-gray-300">{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="text-sm font-semibold mb-4">Recent Activity</h3>
            <div class="space-y-3">
                @forelse($recentActivities as $activity)
                    <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-{{ $activity['color'] }}-500/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-{{ $activity['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $activity['icon'] }}"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">{{ $activity['title'] }}</p>
                            <div class="flex items-center space-x-2">
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['time'] }}</p>
                                @if(isset($activity['details']) && $activity['details'])
                                    <span class="text-xs text-gray-400">•</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['details'] }}</p>
                                @endif
                                @if(isset($activity['calories']) && $activity['calories'])
                                    <span class="text-xs text-gray-400">•</span>
                                    <p class="text-xs text-emerald-500">{{ $activity['calories'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="text-4xl mb-2">🏋️</div>
                        <p class="text-gray-500 dark:text-gray-400">No activity yet</p>
                        <p class="text-sm text-gray-400 dark:text-gray-500">Start your fitness journey today!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Daily Goals & Quote -->
        <div class="space-y-6">
            <!-- Motivational Quote -->
            <div class="bg-gradient-to-r from-emerald-500/10 via-blue-500/10 to-orange-500/10 dark:from-emerald-500/20 dark:via-blue-500/20 dark:to-orange-500/20 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-emerald-500 to-blue-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm italic text-gray-600 dark:text-gray-400">"{{ $quote['text'] ?? 'The only bad workout is the one that didn\'t happen.' }}"</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">— {{ $quote['author'] ?? 'Unknown' }}</p>
                    </div>
                </div>
            </div>

            <!-- Goal Progress Circles -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
                <h3 class="text-sm font-semibold mb-4">Daily Goals Progress</h3>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($dailyGoals as $goal)
                        <div class="text-center">
                            <div class="relative inline-flex items-center justify-center">
                                <svg class="w-16 h-16 transform -rotate-90">
                                    <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="4" fill="none" class="text-gray-200 dark:text-gray-700"/>
                                    <circle cx="32" cy="32" r="28" stroke="currentColor" stroke-width="4" fill="none"
                                            stroke-dasharray="{{ 2 * 3.14159 * 28 }}"
                                            stroke-dashoffset="{{ 2 * 3.14159 * 28 * (1 - $goal['progress'] / 100) }}"
                                            class="text-{{ $goal['color'] }}-500 transition-all duration-1000"/>
                                </svg>
                                <span class="absolute text-sm font-bold">{{ $goal['progress'] }}%</span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $goal['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-emerald-500">{{ $stats['total_exercises'] ?? 0 }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Exercises Completed</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-blue-500">{{ $stats['total_workouts'] ?? 0 }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Workouts Completed</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-orange-500">{{ number_format($stats['total_calories'] ?? 0) }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Total Calories Burned</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-purple-500">{{ number_format(($stats['total_minutes'] ?? 0) / 60, 1) }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Total Hours</p>
        </div>
    </div>
</div>
@endsection