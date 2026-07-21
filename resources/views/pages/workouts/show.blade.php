@extends('layouts.app')

@section('title', 'Workout Details - FitnessPro')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Back Button -->
    <a href="{{ route('workouts.index') }}" class="inline-flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-emerald-500 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Back to Workouts</span>
    </a>

    <!-- Main Content -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50">
        <!-- Hero Image -->
        <div class="relative h-80">
            <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1200&h=500&fit=crop" 
                 alt="Workout" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-8">
                <div class="flex items-center space-x-3 mb-2">
                    <span class="px-3 py-1 bg-emerald-500 text-white text-sm font-medium rounded-full">Strength</span>
                    <span class="px-3 py-1 bg-orange-500/80 text-white text-sm font-medium rounded-full">Intermediate</span>
                </div>
                <h1 class="text-3xl font-bold text-white">Full Body Strength</h1>
                <div class="flex items-center space-x-4 text-white/80 mt-2">
                    <span class="flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>45 min</span>
                    </span>
                    <span class="flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>320 cal</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8 space-y-8">
            <!-- Description -->
            <div>
                <h2 class="text-xl font-bold mb-2">Description</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    A complete full body workout focusing on compound movements for maximum strength gains. 
                    This workout targets all major muscle groups and is designed to build overall strength and muscle mass.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-xl text-center">
                    <p class="text-2xl font-bold text-emerald-500">45</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Minutes</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-xl text-center">
                    <p class="text-2xl font-bold text-blue-500">320</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Calories</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-xl text-center">
                    <p class="text-2xl font-bold text-orange-500">4</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Exercises</p>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-xl text-center">
                    <p class="text-2xl font-bold text-purple-500">3</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Sets Each</p>
                </div>
            </div>

            <!-- Target Muscles -->
            <div>
                <h2 class="text-xl font-bold mb-3">Target Muscles</h2>
                <div class="flex flex-wrap gap-2">
                    @php
                        $muscles = ['Chest', 'Back', 'Legs', 'Shoulders', 'Core'];
                    @endphp
                    @foreach($muscles as $muscle)
                        <span class="px-4 py-2 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl text-sm font-medium">
                            {{ $muscle }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Equipment -->
            <div>
                <h2 class="text-xl font-bold mb-3">Equipment Needed</h2>
                <div class="flex flex-wrap gap-2">
                    @php
                        $equipment = ['Barbell', 'Dumbbells', 'Bench', 'Pull-up Bar'];
                    @endphp
                    @foreach($equipment as $item)
                        <span class="px-4 py-2 bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-xl text-sm font-medium">
                            {{ $item }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Exercises -->
            <div>
                <h2 class="text-xl font-bold mb-4">Exercises</h2>
                <div class="space-y-4">
                    @php
                        $exercises = [
                            ['name' => 'Bench Press', 'sets' => 4, 'reps' => '8-12', 'muscle' => 'Chest'],
                            ['name' => 'Deadlift', 'sets' => 3, 'reps' => '5-8', 'muscle' => 'Back'],
                            ['name' => 'Squats', 'sets' => 4, 'reps' => '8-12', 'muscle' => 'Legs'],
                            ['name' => 'Pull-ups', 'sets' => 3, 'reps' => '8-12', 'muscle' => 'Back'],
                        ];
                    @endphp
                    @foreach($exercises as $exercise)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div>
                                <p class="font-medium">{{ $exercise['name'] }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $exercise['muscle'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-medium">{{ $exercise['sets'] }} sets</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $exercise['reps'] }} reps</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Instructions -->
            <div>
                <h2 class="text-xl font-bold mb-3">Instructions</h2>
                <ul class="space-y-2 list-disc list-inside text-gray-600 dark:text-gray-400">
                    <li>Warm up with 5-10 minutes of light cardio</li>
                    <li>Perform each exercise with proper form</li>
                    <li>Rest 60-90 seconds between sets</li>
                    <li>Cool down with static stretching</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button class="flex-1 px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-105">
                    <span class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Start Workout</span>
                    </span>
                </button>
                <button class="px-6 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium rounded-xl transition-all">
                    <span class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>Save</span>
                    </span>
                </button>
                <button class="px-6 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium rounded-xl transition-all">
                    <span class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        <span>Share</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection