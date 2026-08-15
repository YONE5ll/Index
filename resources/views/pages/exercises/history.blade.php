@extends('layouts.app')

@section('title', 'Exercise History - Byayam')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Exercise History</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Track all your completed exercises</p>
        </div>
        <a href="{{ route('exercises.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
            Back to Exercises
        </a>
    </div>

    <!-- Stats Summary -->
    @php
        $stats = App\Models\UserExerciseProgress::where('user_id', auth()->id())
            ->whereNotNull('completed_at')
            ->get();
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-emerald-500">{{ $stats->count() }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Total Completed</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-blue-500">{{ $stats->sum('duration') }} min</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Total Time</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-orange-500">{{ $stats->sum('calories_burned') }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Total Calories</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-purple-500">{{ $stats->where('completed_at', '>=', now()->startOfWeek())->count() }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">This Week</p>
        </div>
    </div>

    <!-- History List -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 overflow-hidden">
        @forelse($history as $record)
            <div class="flex items-center justify-between p-4 border-b border-gray-200/50 dark:border-gray-800/50 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">{{ $record->exercise->name ?? 'Unknown Exercise' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Completed: {{ $record->completed_at->format('M d, Y h:i A') }}
                        </p>
                        <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                            @if($record->duration)
                                <span>{{ $record->duration }} min</span>
                            @endif
                            @if($record->sets)
                                <span>• {{ $record->sets }} sets</span>
                            @endif
                            @if($record->reps)
                                <span>• {{ $record->reps }} reps</span>
                            @endif
                            @if($record->weight)
                                <span>• {{ $record->weight }} kg</span>
                            @endif
                            @if($record->calories_burned)
                                <span>• {{ $record->calories_burned }} cal</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    @if($record->rating)
                        <p class="text-lg">{{ str_repeat('⭐', $record->rating) }}</p>
                    @endif
                    <a href="{{ route('exercises.show', $record->exercise_id) }}" 
                       class="text-sm text-emerald-500 hover:text-emerald-600 transition-colors">
                        View Exercise
                    </a>
                </div>
            </div>
        @empty
            <div class="p-8 text-center">
                <div class="text-6xl mb-4">📋</div>
                <p class="text-gray-500 dark:text-gray-400">No exercise history yet.</p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Start completing exercises to track your progress!</p>
                <a href="{{ route('exercises.index') }}" class="inline-block mt-4 px-6 py-3 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors">
                    Browse Exercises
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $history->links() }}
    </div>
</div>
@endsection