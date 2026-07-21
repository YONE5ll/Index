@extends('layouts.app')

@section('title', 'Dashboard - Byayam')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-emerald-500/10 via-blue-500/10 to-orange-500/10 dark:from-emerald-500/20 dark:via-blue-500/20 dark:to-orange-500/20 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <h1 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name ?? 'User' }}! 👋</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Here's your fitness overview for today</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
        @php
            $stats = [
                ['label' => 'Calories', 'value' => '1,845', 'target' => '2,200', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'emerald'],
                ['label' => 'Weight', 'value' => '75.5', 'target' => '72', 'unit' => 'kg', 'icon' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3', 'color' => 'blue'],
                ['label' => 'Water', 'value' => '1.8', 'target' => '3', 'unit' => 'L', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'color' => 'blue'],
                ['label' => 'Workout', 'value' => '45', 'target' => '60', 'unit' => 'min', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'orange'],
                ['label' => 'Steps', 'value' => '8,234', 'target' => '10,000', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'emerald'],
                ['label' => 'Sleep', 'value' => '7.5', 'target' => '8', 'unit' => 'hrs', 'icon' => 'M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z', 'color' => 'blue'],
                ['label' => 'BMI', 'value' => '22.4', 'target' => '22', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'color' => 'orange'],
                ['label' => 'Body Fat', 'value' => '15.2', 'target' => '12', 'unit' => '%', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color' => 'emerald'],
            ];
        @endphp

        @foreach($stats as $stat)
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
                    @php
                        $percentage = (float) str_replace(',', '', $stat['value']) / (float) str_replace(',', '', $stat['target']) * 100;
                        $percentage = min($percentage, 100);
                    @endphp
                    <div class="h-full bg-gradient-to-r from-{{ $stat['color'] }}-500 to-{{ $stat['color'] }}-400 rounded-full transition-all duration-1000" 
                         style="width: {{ $percentage }}%"></div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Calories Chart -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="text-sm font-semibold mb-4">Calories This Week</h3>
            <div class="h-48 flex items-end justify-between space-x-2">
                @php
                    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    $calories = [1800, 2100, 1950, 2200, 2050, 2400, 1900];
                @endphp
                @foreach($days as $index => $day)
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-emerald-500/20 rounded-t-lg transition-all duration-500 hover:bg-emerald-500/30"
                             style="height: {{ ($calories[$index] / 2500) * 100 }}%"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $day }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Weight Chart -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="text-sm font-semibold mb-4">Weight Progress</h3>
            <div class="h-48 flex items-end justify-between space-x-2">
                @php
                    $weeks = ['W1', 'W2', 'W3', 'W4', 'W5', 'W6', 'W7'];
                    $weights = [78, 77.2, 76.5, 76, 75.3, 74.8, 75.5];
                @endphp
                @foreach($weights as $index => $weight)
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-blue-500/20 rounded-t-lg transition-all duration-500 hover:bg-blue-500/30"
                             style="height: {{ (80 - $weight) * 10 }}%"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $weeks[$index] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Workout Frequency -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="text-sm font-semibold mb-4">Workout Frequency</h3>
            <div class="h-48 flex items-end justify-between space-x-2">
                @php
                    $workoutDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    $workouts = [1, 0, 1, 1, 0, 1, 0];
                @endphp
                @foreach($workoutDays as $index => $day)
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-full bg-orange-500/20 rounded-t-lg transition-all duration-500 hover:bg-orange-500/30"
                             style="height: {{ $workouts[$index] * 100 }}%"></div>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $day }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="text-sm font-semibold mb-4">Recent Activity</h3>
            <div class="space-y-3">
                @php
                    $activities = [
                        ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'color' => 'emerald', 'title' => 'Completed HIIT Workout', 'time' => '2 hours ago'],
                        ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'blue', 'title' => 'Logged Lunch: 450 calories', 'time' => '4 hours ago'],
                        ['icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'color' => 'blue', 'title' => 'Drank 500ml water', 'time' => '5 hours ago'],
                        ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'color' => 'orange', 'title' => 'Earned "Early Bird" achievement', 'time' => 'Yesterday'],
                    ];
                @endphp
                @foreach($activities as $activity)
                    <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-{{ $activity['color'] }}-500/10 flex items-center justify-center">
                            <svg class="w-4 h-4 text-{{ $activity['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $activity['icon'] }}"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium">{{ $activity['title'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                @endforeach
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
                        <p class="text-sm italic text-gray-600 dark:text-gray-400">"The only bad workout is the one that didn't happen."</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">— Unknown</p>
                    </div>
                </div>
            </div>

            <!-- Goal Progress Circles -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
                <h3 class="text-sm font-semibold mb-4">Daily Goals Progress</h3>
                <div class="grid grid-cols-3 gap-4">
                    @php
                        $goals = [
                            ['label' => 'Workout', 'progress' => 75, 'color' => 'emerald'],
                            ['label' => 'Calories', 'progress' => 85, 'color' => 'blue'],
                            ['label' => 'Water', 'progress' => 60, 'color' => 'blue'],
                        ];
                    @endphp
                    @foreach($goals as $goal)
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
</div>
@endsection