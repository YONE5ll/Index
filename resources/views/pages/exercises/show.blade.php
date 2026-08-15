@extends('layouts.app')

@section('title', $exercise->name . ' - Byayam')

@section('content')
<div class="max-w-6xl mx-auto space-y-8">
    <!-- Back Button -->
    <a href="{{ route('exercises.index') }}" class="inline-flex items-center space-x-2 text-gray-600 dark:text-gray-400 hover:text-emerald-500 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        <span>Back to Exercises</span>
    </a>

    <!-- Exercise Details -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <!-- Image -->
            <div class="relative h-80 lg:h-full min-h-[400px]">
                <img src="{{ $exercise->image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&auto=format' }}" 
                     alt="{{ $exercise->name }}" 
                     class="w-full h-full object-cover">
                @if($progress && $progress->completed_at)
                    <div class="absolute top-4 left-4 px-3 py-1 bg-emerald-500 text-white text-sm font-medium rounded-full flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Completed</span>
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="p-8 space-y-6">
                <div>
                    <div class="flex items-start justify-between">
                        <h1 class="text-3xl font-bold">{{ $exercise->name }}</h1>
                        <button onclick="toggleBookmark({{ $exercise->id }})" 
                                class="p-2 bg-gray-100 dark:bg-gray-800 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-6 h-6 {{ $isBookmarked ? 'text-emerald-500 fill-current' : 'text-gray-500' }}" 
                                 fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" 
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-full text-sm font-medium">
                            {{ $exercise->body_part }}
                        </span>
                        <span class="px-3 py-1 bg-orange-500/10 text-orange-600 dark:text-orange-400 rounded-full text-sm font-medium">
                            {{ $exercise->difficulty }}
                        </span>
                        <span class="px-3 py-1 bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-full text-sm font-medium">
                            {{ $exercise->calories_per_hour ?? 200 }} cal/h
                        </span>
                    </div>
                </div>

                <div>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        {{ $exercise->description ?? 'No description available.' }}
                    </p>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-xl text-center">
                        <p class="text-2xl font-bold text-emerald-500">{{ $totalCompleted ?? 0 }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total Completions</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-xl text-center">
                        <p class="text-2xl font-bold text-blue-500">{{ $progress ? $progress->duration ?? 'N/A' : 'N/A' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Last Duration</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-xl text-center">
                        <p class="text-2xl font-bold text-orange-500">{{ $progress && $progress->rating ? $progress->rating . '⭐' : 'N/A' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Your Rating</p>
                    </div>
                </div>

                <!-- Equipment -->
                <div>
                    <h3 class="font-semibold mb-2">Equipment Needed</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse($exercise->equipment ?? [] as $item)
                            <span class="px-3 py-1.5 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm">{{ $item }}</span>
                        @empty
                            <span class="text-sm text-gray-500 dark:text-gray-400">No equipment required</span>
                        @endforelse
                    </div>
                </div>

                <!-- Target Muscles -->
                <div>
                    <h3 class="font-semibold mb-2">Target Muscles</h3>
                    <div class="flex flex-wrap gap-2">
                        @forelse($exercise->muscle_groups ?? [] as $muscle)
                            <span class="px-3 py-1.5 bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-lg text-sm">{{ $muscle }}</span>
                        @empty
                            <span class="text-sm text-gray-500 dark:text-gray-400">No muscles specified</span>
                        @endforelse
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    @if($progress && !$progress->completed_at)
                        <form method="POST" action="{{ route('exercises.complete', $exercise->id) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-105">
                                Complete Exercise 🎯
                            </button>
                        </form>
                    @elseif(!$progress || $progress->completed_at)
                        <form method="POST" action="{{ route('exercises.start', $exercise->id) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl shadow-lg shadow-blue-500/25 transition-all transform hover:scale-105">
                                Start Exercise 💪
                            </button>
                        </form>
                    @endif
                    
                    @if($progress && $progress->completed_at)
                        <a href="{{ route('exercises.history') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-xl transition-colors font-medium">
                            View History
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Instructions -->
    @if($exercise->instructions)
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="text-xl font-bold mb-4">Instructions</h3>
            <ul class="space-y-2 list-disc list-inside text-gray-600 dark:text-gray-400">
                @foreach($exercise->instructions as $instruction)
                    <li>{{ $instruction }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Related Exercises -->
    @if($relatedExercises->count() > 0)
        <div>
            <h3 class="text-xl font-bold mb-4">Related Exercises</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach($relatedExercises as $related)
                    <a href="{{ route('exercises.show', $related->id) }}" 
                       class="bg-white dark:bg-gray-900 rounded-xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50 hover:shadow-lg transition-all hover:-translate-y-1">
                        <img src="{{ $related->image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=200&h=150&fit=crop&auto=format' }}" 
                             alt="{{ $related->name }}" 
                             class="w-full h-32 object-cover">
                        <div class="p-3">
                            <h4 class="font-medium text-sm">{{ $related->name }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $related->body_part }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Progress History -->
    @if($progress)
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="text-xl font-bold mb-4">Your Progress History</h3>
            <div class="space-y-3">
                @php
                    $history = App\Models\UserExerciseProgress::where('exercise_id', $exercise->id)
                        ->where('user_id', auth()->id())
                        ->whereNotNull('completed_at')
                        ->orderBy('completed_at', 'desc')
                        ->limit(10)
                        ->get();
                @endphp
                @forelse($history as $record)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <div>
                            <p class="font-medium">{{ $record->completed_at->format('M d, Y h:i A') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $record->duration }} min • {{ $record->sets ?? 'N/A' }} sets • {{ $record->reps ?? 'N/A' }} reps
                                @if($record->weight)
                                    • {{ $record->weight }} kg
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            @if($record->rating)
                                <p class="text-lg">{{ str_repeat('⭐', $record->rating) }}</p>
                            @endif
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $record->calories_burned ?? 0 }} cal burned</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">No history yet. Start completing exercises!</p>
                @endforelse
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function toggleBookmark(exerciseId) {
    fetch(`/exercises/${exerciseId}/bookmark`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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