@extends('layouts.app')

@section('title', 'Challenges - FitnessPro')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Challenges</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Push your limits and earn rewards</p>
        </div>
        <div class="flex items-center space-x-3">
            <select class="px-4 py-2.5 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                <option>All Challenges</option>
                <option>Active</option>
                <option>Completed</option>
                <option>Upcoming</option>
            </select>
        </div>
    </div>

    <!-- Active Challenges -->
    <div>
        <h2 class="text-xl font-bold mb-4">Your Active Challenges</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @php
                $activeChallenges = [
                    [
                        'name' => '30-Day Beginner Plan',
                        'progress' => 60,
                        'days_left' => 12,
                        'image' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400&h=300&fit=crop&auto=format',
                        'color' => 'emerald'
                    ],
                    [
                        'name' => 'Push-Up Challenge',
                        'progress' => 45,
                        'days_left' => 17,
                        'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=300&fit=crop&auto=format',
                        'color' => 'blue'
                    ],
                ];
            @endphp
            @foreach($activeChallenges as $challenge)
                <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50 hover:shadow-xl transition-all">
                    <div class="relative h-40">
                        <img src="{{ $challenge['image'] }}" alt="{{ $challenge['name'] }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-3 left-3 right-3">
                            <h3 class="text-white font-bold">{{ $challenge['name'] }}</h3>
                            <div class="flex items-center space-x-3 text-white/80 text-sm">
                                <span>{{ $challenge['progress'] }}% complete</span>
                                <span>•</span>
                                <span>{{ $challenge['days_left'] }} days left</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-{{ $challenge['color'] }}-500 to-{{ $challenge['color'] }}-400 rounded-full transition-all duration-1000" 
                                 style="width: {{ $challenge['progress'] }}%"></div>
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $challenge['progress'] }}% completed</span>
                            <button class="px-4 py-1.5 text-sm bg-{{ $challenge['color'] }}-500 text-white rounded-lg hover:bg-{{ $challenge['color'] }}-600 transition-colors">
                                Continue
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Available Challenges -->
    <div>
        <h2 class="text-xl font-bold mb-4">Available Challenges</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $availableChallenges = [
                    [
                        'name' => '10K Steps Daily',
                        'description' => 'Walk 10,000 steps every day for 30 days',
                        'difficulty' => 'Beginner',
                        'duration' => '30 days',
                        'participants' => 2134,
                        'image' => 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?w=400&h=300&fit=crop&auto=format',
                        'color' => 'emerald',
                        'featured' => true
                    ],
                    [
                        'name' => '100 Squat Challenge',
                        'description' => 'Complete 100 squats every day for 21 days',
                        'difficulty' => 'Intermediate',
                        'duration' => '21 days',
                        'participants' => 856,
                        'image' => 'https://cdn.pixabay.com/photo/2019/06/02/04/36/outdoors-4245628_1280.jpg',
                        'color' => 'orange',
                        'featured' => false
                    ],
                    [
                        'name' => 'Plank Progression',
                        'description' => 'Increase your plank time every day for 30 days',
                        'difficulty' => 'Advanced',
                        'duration' => '30 days',
                        'participants' => 423,
                        'image' => 'https://images.unsplash.com/photo-1714646442330-9068099f5521?q=80&w=1332&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                        'color' => 'blue',
                        'featured' => false
                    ],
                ];
            @endphp
            @foreach($availableChallenges as $challenge)
                <div class="group bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50 hover:shadow-xl transition-all hover:-translate-y-1">
                    <div class="relative h-48">
                        <img src="{{ $challenge['image'] }}" alt="{{ $challenge['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @if($challenge['featured'])
                            <div class="absolute top-3 right-3 px-3 py-1 bg-gradient-to-r from-emerald-500 to-blue-500 text-white text-xs font-medium rounded-full">
                                Featured
                            </div>
                        @endif
                        <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-{{ $challenge['color'] }}-500/90 text-white">
                                {{ $challenge['difficulty'] }}
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold mb-1">{{ $challenge['name'] }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $challenge['description'] }}</p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">⏱️ {{ $challenge['duration'] }}</span>
                            <span class="text-gray-500 dark:text-gray-400">👥 {{ $challenge['participants'] }}</span>
                        </div>
                        <button class="mt-3 w-full py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl transition-all transform hover:scale-105">
                            Join Challenge
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Challenge Progress (30-Day Plan Detail) -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <h3 class="text-xl font-bold mb-4">30-Day Beginner Plan - Progress</h3>
        <div class="space-y-3">
            @php
                $days = [];
                for ($i = 1; $i <= 30; $i++) {
                    $days[] = [
                        'day' => $i,
                        'completed' => $i <= 18 ? true : false,
                        'title' => $i <= 18 ? 'Workout Completed' : 'Day ' . $i,
                    ];
                }
            @endphp
            <div class="grid grid-cols-5 md:grid-cols-10 lg:grid-cols-15 gap-2">
                @foreach($days as $day)
                    <div class="text-center">
                        <div class="w-full aspect-square rounded-lg {{ $day['completed'] ? 'bg-emerald-500' : 'bg-gray-200 dark:bg-gray-700' }} flex items-center justify-center transition-all">
                            @if($day['completed'])
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $day['day'] }}</span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 block">{{ $day['day'] }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex items-center justify-between mt-4">
                <div class="flex items-center space-x-4 text-sm">
                    <span class="flex items-center space-x-2">
                        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                        <span class="text-gray-600 dark:text-gray-400">Completed</span>
                    </span>
                    <span class="flex items-center space-x-2">
                        <span class="w-3 h-3 bg-gray-200 dark:bg-gray-700 rounded-full"></span>
                        <span class="text-gray-600 dark:text-gray-400">Remaining</span>
                    </span>
                </div>
                <span class="text-sm font-medium text-emerald-500">60% Complete</span>
            </div>
        </div>
    </div>
</div>
@endsection