@extends('layouts.app')

@section('title', 'Workouts - FitnessPro')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Workout Plans</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Choose from our curated workout plans</p>
        </div>
        <button class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-105">
            <span class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Create Plan</span>
            </span>
        </button>
    </div>

    <!-- Categories -->
    <div class="flex flex-wrap gap-2">
        @php
            $categories = ['All', 'Strength', 'Hypertrophy', 'Powerlifting', 'Calisthenics', 'Yoga', 'HIIT', 'Cardio', 'CrossFit'];
        @endphp
        @foreach($categories as $category)
            <button class="px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 
                {{ $loop->first ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/25' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                {{ $category }}
            </button>
        @endforeach
    </div>

    <!-- Workout Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $workouts = [
                [
                    'title' => 'Full Body Strength',
                    'category' => 'Strength',
                    'difficulty' => 'Intermediate',
                    'duration' => '45 min',
                    'calories' => 320,
                    'muscles' => ['Chest', 'Back', 'Legs', 'Shoulders'],
                    'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400&h=300&fit=crop',
                    'bookmarked' => false,
                    'color' => 'emerald'
                ],
                [
                    'title' => 'HIIT Cardio Blast',
                    'category' => 'HIIT',
                    'difficulty' => 'Advanced',
                    'duration' => '30 min',
                    'calories' => 450,
                    'muscles' => ['Full Body', 'Cardio'],
                    'image' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=400&h=300&fit=crop',
                    'bookmarked' => true,
                    'color' => 'orange'
                ],
                [
                    'title' => 'Yoga Flow',
                    'category' => 'Yoga',
                    'difficulty' => 'Beginner',
                    'duration' => '60 min',
                    'calories' => 200,
                    'muscles' => ['Core', 'Flexibility', 'Balance'],
                    'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=400&h=300&fit=crop',
                    'bookmarked' => false,
                    'color' => 'blue'
                ],
                [
                    'title' => 'Leg Day Supreme',
                    'category' => 'Strength',
                    'difficulty' => 'Intermediate',
                    'duration' => '50 min',
                    'calories' => 380,
                    'muscles' => ['Quads', 'Hamstrings', 'Glutes', 'Calves'],
                    'image' => 'https://trufitathleticclubs.com/wp-content/uploads/2026/01/shutterstock_2663749503_dumbbell.webp',
                    'bookmarked' => false,
                    'color' => 'emerald'
                ],
                [
                    'title' => 'Calisthenics Basics',
                    'category' => 'Calisthenics',
                    'difficulty' => 'Beginner',
                    'duration' => '40 min',
                    'calories' => 250,
                    'muscles' => ['Chest', 'Back', 'Core'],
                    'image' => 'https://images.unsplash.com/photo-1594381898411-846e7d193883?w=400&h=300&fit=crop',
                    'bookmarked' => false,
                    'color' => 'blue'
                ],
                [
                    'title' => 'CrossFit WOD',
                    'category' => 'CrossFit',
                    'difficulty' => 'Advanced',
                    'duration' => '35 min',
                    'calories' => 500,
                    'muscles' => ['Full Body', 'Cardio', 'Strength'],
                    'image' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400&h=300&fit=crop',
                    'bookmarked' => true,
                    'color' => 'orange'
                ],
            ];
        @endphp

        @foreach($workouts as $workout)
            <div class="group bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <!-- Image -->
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $workout['image'] }}" alt="{{ $workout['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1 bg-black/60 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                            {{ $workout['category'] }}
                        </span>
                    </div>
                    <button class="absolute top-3 right-3 p-2 bg-black/40 backdrop-blur-sm rounded-full hover:bg-emerald-500 transition-colors">
                        <svg class="w-4 h-4 text-white {{ $workout['bookmarked'] ? 'fill-current' : '' }}" fill="{{ $workout['bookmarked'] ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </button>
                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent">
                        <div class="flex items-center space-x-3 text-white text-xs">
                            <span class="flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $workout['duration'] }}</span>
                            </span>
                            <span class="flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $workout['calories'] }} cal</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5">
                    <h3 class="text-lg font-bold mb-1">{{ $workout['title'] }}</h3>
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-{{ $workout['color'] }}-500/10 text-{{ $workout['color'] }}-500">
                            {{ $workout['difficulty'] }}
                        </span>
                        <div class="flex items-center space-x-1">
                            @foreach($workout['muscles'] as $muscle)
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $muscle }}</span>
                                @if(!$loop->last)
                                    <span class="text-xs text-gray-300 dark:text-gray-600">•</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button class="flex-1 px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white text-sm font-medium rounded-xl transition-all transform hover:scale-105">
                            Start Workout
                        </button>
                        <button class="p-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-xl transition-colors">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection