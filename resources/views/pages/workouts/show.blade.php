@extends('layouts.app')

@section('title', $workout->title . ' - Byayam')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <!-- Back Button -->
    <a href="{{ route('workouts.index') }}" class="inline-flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-emerald-500 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Back to Workouts</span>
    </a>

    <!-- Workout Details -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <!-- Image -->
            <div class="relative h-80 lg:h-full min-h-[400px]">
                <img src="{{ $workout->image_url ?? 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&h=600&fit=crop&auto=format' }}" 
                     alt="{{ $workout->title }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1 bg-emerald-500 text-white text-sm font-medium rounded-full">{{ $workout->category }}</span>
                        <span class="px-3 py-1 bg-orange-500 text-white text-sm font-medium rounded-full">{{ $workout->difficulty }}</span>
                        @if($workout->is_featured)
                            <span class="px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded-full">⭐ Featured</span>
                        @endif
                        @if($hasCompleted)
                            <span class="px-3 py-1 bg-emerald-500 text-white text-sm font-medium rounded-full flex items-center space-x-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Completed</span>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="p-8 space-y-6">
                <div>
                    <div class="flex items-start justify-between">
                        <h1 class="text-3xl font-bold">{{ $workout->title }}</h1>
                        <button onclick="toggleBookmark({{ $workout->id }})" 
                                class="p-2 bg-gray-100 dark:bg-gray-800 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-6 h-6 {{ $isBookmarked ? 'text-emerald-500 fill-current' : 'text-gray-500' }}" 
                                 fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" 
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $workout->description }}</p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-xl text-center">
                        <p class="text-2xl font-bold text-emerald-500">{{ $workout->duration }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Minutes</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-xl text-center">
                        <p class="text-2xl font-bold text-blue-500">{{ $workout->calories_burned }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Calories</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-xl text-center">
                        <p class="text-2xl font-bold text-orange-500">{{ $workout->exercises_count }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Exercises</p>
                    </div>
                </div>

                <!-- Target Muscles -->
                <div>
                    <h3 class="font-semibold mb-2">Target Muscles</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse($workout->target_muscles ?? [] as $muscle)
                            <span class="px-3 py-1.5 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-lg text-sm">{{ $muscle }}</span>
                        @empty
                            <span class="text-sm text-gray-500 dark:text-gray-400">No muscles specified</span>
                        @endforelse
                    </div>
                </div>

                <!-- Equipment -->
                <div>
                    <h3 class="font-semibold mb-2">Equipment Needed</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse($workout->equipment ?? [] as $item)
                            <span class="px-3 py-1.5 bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-lg text-sm">{{ $item }}</span>
                        @empty
                            <span class="text-sm text-gray-500 dark:text-gray-400">No equipment required</span>
                        @endforelse
                    </div>
                </div>

                <!-- User Progress -->
                @if($userProgress)
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <h3 class="font-semibold mb-2">Your Progress</h3>
                        <div class="flex items-center space-x-4 text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Completed: {{ $userProgress->completed_at->format('M d, Y') }}</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600 dark:text-gray-400">Rating: {{ $userProgress->rating ? str_repeat('⭐', $userProgress->rating) : 'Not rated' }}</span>
                            @if($userProgress->notes)
                                <span class="text-gray-400">•</span>
                                <span class="text-gray-600 dark:text-gray-400">Notes: {{ $userProgress->notes }}</span>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    @if($inProgress)
                        <form method="POST" action="{{ route('workouts.complete', $workout->id) }}" class="flex-1 flex flex-wrap gap-2">
                            @csrf
                            <div class="w-full flex flex-wrap gap-2">
                                <input type="number" name="duration" placeholder="Duration (min)" class="flex-1 min-w-[120px] px-4 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm" value="{{ $workout->duration }}">
                                <input type="number" name="calories_burned" placeholder="Calories" class="flex-1 min-w-[120px] px-4 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm" value="{{ $workout->calories_burned }}">
                                <select name="rating" class="flex-1 min-w-[100px] px-4 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 text-sm">
                                    <option value="">Rate (1-5)</option>
                                    <option value="1">⭐</option>
                                    <option value="2">⭐⭐</option>
                                    <option value="3">⭐⭐⭐</option>
                                    <option value="4">⭐⭐⭐⭐</option>
                                    <option value="5">⭐⭐⭐⭐⭐</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-105">
                                Complete Workout 🎯
                            </button>
                        </form>
                    @elseif(!$hasCompleted)
                        <form method="POST" action="{{ route('workouts.start', $workout->id) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl shadow-lg shadow-blue-500/25 transition-all transform hover:scale-105">
                                Start Workout 💪
                            </button>
                        </form>
                    @else
                        <div class="w-full text-center py-3 bg-gray-100 dark:bg-gray-800 rounded-xl">
                            <span class="text-gray-600 dark:text-gray-400">✅ You've completed this workout!</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Exercises List -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <h3 class="text-xl font-bold mb-4">Exercises</h3>
        <div class="space-y-4">
            @foreach($workout->exercises as $exercise)
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <p class="font-medium">{{ $exercise->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $exercise->pivot->sets }} sets × {{ $exercise->pivot->reps }} reps</p>
                        @if($exercise->pivot->rest_seconds)
                            <p class="text-xs text-gray-400">Rest: {{ $exercise->pivot->rest_seconds }} seconds</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $exercise->body_part }}</span>
                        <br>
                        <span class="text-xs text-gray-400">{{ $exercise->difficulty }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Related Workouts -->
    @if($relatedWorkouts->count() > 0)
        <div>
            <h3 class="text-xl font-bold mb-4">Related Workouts</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach($relatedWorkouts as $related)
                    <a href="{{ route('workouts.show', $related->id) }}" 
                       class="bg-white dark:bg-gray-900 rounded-xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50 hover:shadow-lg transition-all hover:-translate-y-1">
                        <img src="{{ $related->image_url ?? 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=200&h=150&fit=crop&auto=format' }}" 
                             alt="{{ $related->title }}" 
                             class="w-full h-32 object-cover">
                        <div class="p-3">
                            <h4 class="font-medium text-sm">{{ $related->title }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $related->duration }} min • {{ $related->calories_burned }} cal</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

function toggleBookmark(workoutId) {
    fetch(`/workouts/${workoutId}/bookmark`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endpush
@endsection