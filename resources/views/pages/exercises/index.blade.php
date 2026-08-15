@extends('layouts.app')

@section('title', 'Exercise Library - Byayam')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Exercise Library</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Browse our comprehensive exercise database</p>
        </div>
        <div class="flex items-center space-x-3">
            <!-- Search Form -->
            <form method="GET" action="{{ route('exercises.index') }}" class="relative">
                <input type="text" 
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search exercises..." 
                       class="w-full md:w-64 px-4 py-2.5 pl-10 bg-gray-100 dark:bg-gray-800 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </form>
            <a href="{{ route('exercises.create') }}" class="px-4 py-2.5 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Add Exercise</span>
            </a>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-emerald-500">{{ $exercises->total() }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Total Exercises</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-blue-500">{{ $bodyParts->count() }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Body Parts</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-orange-500">{{ $difficulties->count() }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Difficulty Levels</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-purple-500">{{ count($completedIds ?? []) }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Completed</p>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 text-center">
            <p class="text-2xl font-bold text-pink-500">{{ count($bookmarkedIds ?? []) }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">Bookmarked</p>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('exercises.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <!-- Preserve search query -->
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Body Part</label>
            <select name="body_part" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                <option value="All">All Body Parts</option>
                @foreach($bodyParts as $part)
                    <option value="{{ $part }}" {{ request('body_part') == $part ? 'selected' : '' }}>{{ $part }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Difficulty</label>
            <select name="difficulty" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                <option value="All">All Levels</option>
                @foreach($difficulties as $difficulty)
                    <option value="{{ $difficulty }}" {{ request('difficulty') == $difficulty ? 'selected' : '' }}>{{ $difficulty }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Equipment</label>
            <select name="equipment" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                <option value="All">All Equipment</option>
                @foreach($allEquipment as $equipment)
                    <option value="{{ $equipment }}" {{ request('equipment') == $equipment ? 'selected' : '' }}>{{ $equipment }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Muscle Group</label>
            <select name="muscle_group" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                <option value="All">All Muscles</option>
                @foreach($allMuscles as $muscle)
                    <option value="{{ $muscle }}" {{ request('muscle_group') == $muscle ? 'selected' : '' }}>{{ $muscle }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sort By</label>
            <select name="sort" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                <option value="body_part" {{ request('sort') == 'body_part' ? 'selected' : '' }}>Body Part</option>
                <option value="difficulty" {{ request('sort') == 'difficulty' ? 'selected' : '' }}>Difficulty</option>
                <option value="calories_per_hour" {{ request('sort') == 'calories_per_hour' ? 'selected' : '' }}>Calories</option>
                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest</option>
            </select>
        </div>
    </form>

    <!-- Exercise Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($exercises as $exercise)
            <div class="group bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="relative h-48 overflow-hidden cursor-pointer" onclick="window.location='{{ route('exercises.show', $exercise->id) }}'">
                    <img src="{{ $exercise->image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&h=300&fit=crop&auto=format' }}" 
                         alt="{{ $exercise->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    
                    <!-- Status Badges -->
                    <div class="absolute top-3 left-3 flex flex-col gap-1">
                        <span class="px-3 py-1 bg-black/60 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                            {{ $exercise->body_part }}
                        </span>
                        @if(in_array($exercise->id, $completedIds ?? []))
                            <span class="px-3 py-1 bg-emerald-500/90 backdrop-blur-sm text-white text-xs font-medium rounded-full flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Completed</span>
                            </span>
                        @endif
                    </div>
                    
                    <!-- Bookmark Button -->
                    <button onclick="event.stopPropagation(); toggleBookmark({{ $exercise->id }})" 
                            class="absolute top-3 right-3 p-2 bg-black/40 backdrop-blur-sm rounded-full hover:bg-emerald-500 transition-colors">
                        <svg class="w-4 h-4 text-white {{ in_array($exercise->id, $bookmarkedIds ?? []) ? 'fill-current' : '' }}" 
                             fill="{{ in_array($exercise->id, $bookmarkedIds ?? []) ? 'currentColor' : 'none' }}" 
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </button>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent">
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-500/90 text-white">
                                {{ $exercise->difficulty }}
                            </span>
                            <span class="text-white/80 text-xs flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $exercise->calories_per_hour ?? 200 }} cal/h</span>
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="p-5">
                    <h3 class="text-lg font-bold mb-1">{{ $exercise->name }}</h3>
                    <div class="flex flex-wrap gap-1 mb-3">
                        @foreach($exercise->equipment ?? [] as $item)
                            <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded-full">{{ $item }}</span>
                        @endforeach
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex flex-wrap gap-1">
                            @foreach($exercise->muscle_groups ?? [] as $muscle)
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $muscle }}</span>
                                @if(!$loop->last)
                                    <span class="text-xs text-gray-300 dark:text-gray-600">•</span>
                                @endif
                            @endforeach
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('exercises.show', $exercise->id) }}" 
                               class="p-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <div class="text-6xl mb-4">🏋️</div>
                <p class="text-gray-500 dark:text-gray-400">No exercises found matching your criteria.</p>
                <a href="{{ route('exercises.create') }}" class="inline-block mt-4 px-6 py-3 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors">
                    Create Your First Exercise
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $exercises->links() }}
    </div>
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