@extends('layouts.app')

@section('title', 'Achievements - FitnessPro')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold">Achievements</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Track your milestones and celebrate your progress</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $stats = [
                ['label' => 'Total Achievements', 'value' => '8', 'icon' => '🏆', 'color' => 'emerald'],
                ['label' => 'Unlocked', 'value' => '3', 'icon' => '⭐', 'color' => 'blue'],
                ['label' => 'Total Points', 'value' => '450', 'icon' => '💎', 'color' => 'orange'],
                ['label' => 'Next Achievement', 'value' => '30-Day Streak', 'icon' => '🎯', 'color' => 'purple'],
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

    <!-- Achievement Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $achievements = [
                ['name' => 'First Workout', 'desc' => 'Complete your first workout', 'icon' => '🏋️', 'points' => 50, 'rarity' => 'Common', 'color' => 'gray', 'unlocked' => true, 'date' => 'Jan 15, 2024'],
                ['name' => '7-Day Streak', 'desc' => 'Work out for 7 days in a row', 'icon' => '🔥', 'points' => 100, 'rarity' => 'Uncommon', 'color' => 'emerald', 'unlocked' => true, 'date' => 'Jan 22, 2024'],
                ['name' => '30-Day Streak', 'desc' => 'Work out for 30 days in a row', 'icon' => '⚡', 'points' => 200, 'rarity' => 'Rare', 'color' => 'blue', 'unlocked' => false, 'progress' => 60],
                ['name' => 'Weight Loss', 'desc' => 'Lose 5kg of body weight', 'icon' => '🎯', 'points' => 150, 'rarity' => 'Rare', 'color' => 'orange', 'unlocked' => false, 'progress' => 80],
                ['name' => 'Strength Master', 'desc' => 'Complete 100 strength sessions', 'icon' => '💪', 'points' => 250, 'rarity' => 'Epic', 'color' => 'purple', 'unlocked' => false, 'progress' => 45],
                ['name' => 'Cardio King', 'desc' => 'Burn 10,000 calories through cardio', 'icon' => '❤️', 'points' => 200, 'rarity' => 'Rare', 'color' => 'red', 'unlocked' => false, 'progress' => 30],
                ['name' => 'Early Bird', 'desc' => 'Complete 10 workouts before 7 AM', 'icon' => '🌅', 'points' => 100, 'rarity' => 'Uncommon', 'color' => 'yellow', 'unlocked' => true, 'date' => 'Feb 1, 2024'],
                ['name' => 'Fitness Guru', 'desc' => 'Complete 500 total workouts', 'icon' => '🌟', 'points' => 500, 'rarity' => 'Legendary', 'color' => 'emerald', 'unlocked' => false, 'progress' => 17],
            ];
        @endphp
        @foreach($achievements as $achievement)
            <div class="group bg-white dark:bg-gray-900 rounded-2xl p-4 border {{ $achievement['unlocked'] ? 'border-emerald-500/30 dark:border-emerald-500/30' : 'border-gray-200/50 dark:border-gray-800/50' }} hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="text-center">
                    <div class="text-4xl mb-2 {{ $achievement['unlocked'] ? '' : 'opacity-30' }}">{{ $achievement['icon'] }}</div>
                    <h4 class="font-bold text-sm">{{ $achievement['name'] }}</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $achievement['desc'] }}</p>
                    @if($achievement['unlocked'])
                        <div class="mt-2 inline-block px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                            Unlocked
                        </div>
                        <p class="text-xs text-gray-400 mt-1">{{ $achievement['date'] }}</p>
                    @else
                        @if(isset($achievement['progress']))
                            <div class="mt-2">
                                <div class="w-full h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-{{ $achievement['color'] }}-500 to-{{ $achievement['color'] }}-400 rounded-full transition-all duration-1000" 
                                         style="width: {{ $achievement['progress'] }}%"></div>
                                </div>
                                <span class="text-xs text-gray-400">{{ $achievement['progress'] }}%</span>
                            </div>
                        @endif
                        <div class="mt-2 inline-block px-2 py-0.5 text-xs font-medium rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                            Locked
                        </div>
                    @endif
                    <div class="mt-2 flex items-center justify-center space-x-2 text-xs">
                        <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">
                            {{ $achievement['rarity'] }}
                        </span>
                        <span class="text-gray-400">•</span>
                        <span class="text-gray-500 dark:text-gray-400">{{ $achievement['points'] }} pts</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Progress to Next Achievement -->
    <div class="bg-gradient-to-r from-emerald-500/10 via-blue-500/10 to-orange-500/10 dark:from-emerald-500/20 dark:via-blue-500/20 dark:to-orange-500/20 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <h3 class="font-semibold mb-2">Next Achievement</h3>
        <div class="flex items-center justify-between">
            <div>
                <p class="text-lg font-bold">30-Day Streak</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Work out for 30 days in a row</p>
            </div>
            <div class="text-right">
                <span class="text-2xl font-bold text-emerald-500">60%</span>
                <p class="text-xs text-gray-500 dark:text-gray-400">18/30 days</p>
            </div>
        </div>
        <div class="mt-3 w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
            <div class="h-full bg-gradient-to-r from-emerald-500 to-blue-500 rounded-full transition-all duration-1000" 
                 style="width: 60%"></div>
        </div>
    </div>
</div>
@endsection