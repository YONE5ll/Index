@extends('layouts.app')

@section('title', $challenge->name . ' - Byayam')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <!-- Back Button -->
    <a href="{{ route('challenges.index') }}" class="inline-flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-emerald-500 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Back to Challenges</span>
    </a>

    <!-- Challenge Header -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50">
        <div class="relative h-64">
            <img src="{{ $challenge->image_url ?? 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=1200&h=400&fit=crop&auto=format' }}" 
                 alt="{{ $challenge->name }}" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-8">
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    <span class="px-3 py-1 bg-{{ $challenge->color ?? 'emerald' }}-500 text-white text-sm font-medium rounded-full">
                        {{ $challenge->difficulty }}
                    </span>
                    @if($challenge->is_featured)
                        <span class="px-3 py-1 bg-gradient-to-r from-emerald-500 to-blue-500 text-white text-sm font-medium rounded-full">
                            ⭐ Featured
                        </span>
                    @endif
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-sm font-medium rounded-full">
                        {{ $challenge->duration }} Days
                    </span>
                    <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-sm font-medium rounded-full">
                        👥 {{ $challenge->participants }} participants
                    </span>
                </div>
                <h1 class="text-3xl font-bold text-white">{{ $challenge->name }}</h1>
                <p class="text-white/80 mt-2">{{ $challenge->description }}</p>
            </div>
        </div>
    </div>

    <!-- Challenge Actions & Progress -->
    @if(auth()->check())
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            @if($isJoined && $progress)
                <!-- Progress Bar -->
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium">Progress</span>
                        <span class="text-sm font-medium text-emerald-500">{{ $progress->progress_percentage }}%</span>
                    </div>
                    <div class="w-full h-3 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full transition-all duration-1000" 
                             style="width: {{ $progress->progress_percentage }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mt-2">
                        <span>{{ $progress->completed_days }} days completed</span>
                        <span>{{ $progress->days_left }} days remaining</span>
                    </div>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-2xl font-bold text-emerald-500">{{ $progress->streak }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">🔥 Streak</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-2xl font-bold text-blue-500">{{ $progress->total_calories_burned }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">🔥 Calories</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-2xl font-bold text-orange-500">{{ floor($progress->total_duration / 60) }}h</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">⏱️ Total Time</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-2xl font-bold text-purple-500">{{ $progress->status_text }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">📊 Status</p>
                    </div>
                </div>

                <!-- Leave Challenge -->
                <form action="{{ route('challenges.leave', $challenge->id) }}" method="POST" class="text-right">
                    @csrf
                    <button type="submit" class="text-sm text-red-500 hover:text-red-600 transition-colors" 
                            onclick="return confirm('Are you sure you want to leave this challenge?')">
                        Leave Challenge
                    </button>
                </form>
            @elseif(!$isJoined)
                <form action="{{ route('challenges.join', $challenge->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-105">
                        Join Challenge 🚀
                    </button>
                </form>
            @endif
        </div>
    @endif

    <!-- Challenge Days Timeline -->
    <div>
        <h2 class="text-2xl font-bold mb-4">📅 Challenge Timeline</h2>
        <div class="space-y-3">
            @foreach($challenge->days as $day)
                @php
                    $isCompleted = isset($dayProgress[$day->day_number]) && $dayProgress[$day->day_number]->is_completed;
                    $dayProgressData = $dayProgress[$day->day_number] ?? null;
                @endphp
                <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 hover:shadow-md transition-all 
                            {{ $isCompleted ? 'border-emerald-500/30 dark:border-emerald-500/30' : '' }}">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold 
                                        {{ $isCompleted ? 'bg-emerald-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400' }}">
                                {{ $day->day_number }}
                            </div>
                            <div>
                                <h4 class="font-semibold">{{ $day->workout_name }}</h4>
                                <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span>{{ $day->sets }} sets × {{ $day->reps }} reps</span>
                                    <span>•</span>
                                    <span>🔥 {{ $day->estimated_calories ?? 0 }} cal</span>
                                    <span>•</span>
                                    <span>⏱️ {{ $day->estimated_duration ?? 0 }} min</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            @if($day->exercises)
                                <button onclick="showExercises({{ $day->day_number }})" 
                                        class="text-sm text-blue-500 hover:text-blue-600 transition-colors">
                                    View Exercises
                                </button>
                            @endif
                            @if($isCompleted)
                                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-full text-sm font-medium flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Completed</span>
                                </span>
                                @if($dayProgressData && $dayProgressData->duration)
                                    <span class="text-xs text-gray-400">{{ $dayProgressData->duration }} min</span>
                                @endif
                            @elseif($isJoined && $progress && $progress->status != 3)
                                <button onclick="completeDay({{ $day->day_number }})" 
                                        class="px-4 py-2 bg-emerald-500 text-white text-sm font-medium rounded-xl hover:bg-emerald-600 transition-colors">
                                    Complete Day 🎯
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Requirements & Rewards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @if($challenge->requirements)
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
                <h3 class="font-semibold mb-3">📋 Requirements</h3>
                <ul class="space-y-2">
                    @foreach($challenge->requirements as $requirement)
                        <li class="flex items-start space-x-2 text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $requirement }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($challenge->rewards)
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
                <h3 class="font-semibold mb-3">🏆 Rewards</h3>
                <ul class="space-y-2">
                    @foreach($challenge->rewards as $reward)
                        <li class="flex items-start space-x-2 text-gray-600 dark:text-gray-400">
                            <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            <span>{{ $reward }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>

<!-- Exercises Modal -->
<div x-data="{ open: false, exercises: [], dayNumber: 0 }" 
     x-on:keydown.escape.window="open = false"
     class="fixed inset-0 z-50 overflow-y-auto" 
     x-show="open" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display: none;">
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="open = false"></div>
        <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>
        <div class="inline-block w-full max-w-2xl p-6 my-8 text-left align-middle bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200/50 dark:border-gray-800/50 transform transition-all"
             x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <h3 class="text-xl font-bold mb-4" x-text="'Day ' + dayNumber + ' Exercises'"></h3>
            <div class="space-y-3">
                <template x-for="exercise in exercises" :key="exercise">
                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="font-medium" x-text="exercise"></p>
                    </div>
                </template>
            </div>
            <button @click="open = false" class="mt-4 w-full py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-xl transition-colors font-medium">
                Close
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

function showExercises(dayNumber) {
    // Get exercises for this day from the challenge data
    @php
        $exercisesByDay = [];
        foreach($challenge->days as $day) {
            $exercisesByDay[$day->day_number] = $day->exercises ?? [];
        }
    @endphp
    
    const exercises = @json($exercisesByDay);
    const dayExercises = exercises[dayNumber] || ['No exercises listed'];
    
    // Access the Alpine component
    const modal = document.querySelector('[x-data]').__x.$data;
    modal.open = true;
    modal.dayNumber = dayNumber;
    modal.exercises = dayExercises;
}

function completeDay(dayNumber) {
    if (!confirm('Complete day ' + dayNumber + '?')) return;
    
    const duration = prompt('How many minutes did you spend? (optional)', '');
    const calories = prompt('How many calories did you burn? (optional)', '');
    
    fetch('{{ route("challenges.complete", $challenge->id) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            day_number: dayNumber,
            duration: duration || null,
            calories_burned: calories || null,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.error || 'Failed to complete day');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}
</script>
@endpush
@endsection