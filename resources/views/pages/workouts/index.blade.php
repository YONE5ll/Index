@extends('layouts.app')

@section('title', 'Workouts - Byayam')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Workout Plans</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Choose from our curated workout plans</p>
        </div>
        <a href="{{ route('workouts.create') }}" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-105 flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Create Plan</span>
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50">
        <form method="GET" action="{{ route('workouts.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                <select name="category" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                    <option value="All">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Difficulty</label>
                <select name="difficulty" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                    <option value="">All Levels</option>
                    @foreach($difficulties as $difficulty)
                        <option value="{{ $difficulty }}" {{ request('difficulty') == $difficulty ? 'selected' : '' }}>{{ $difficulty }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sort By</label>
                <select name="sort" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
                    <option value="category" {{ request('sort') == 'category' ? 'selected' : '' }}>Category</option>
                    <option value="difficulty" {{ request('sort') == 'difficulty' ? 'selected' : '' }}>Difficulty</option>
                    <option value="duration" {{ request('sort') == 'duration' ? 'selected' : '' }}>Duration</option>
                    <option value="calories_burned" {{ request('sort') == 'calories_burned' ? 'selected' : '' }}>Calories</option>
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest</option>
                </select>
            </div>
            <div class="md:col-span-2 flex items-end space-x-2">
                <div class="flex-1 relative">
                    <input type="text" 
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search workouts..." 
                           class="w-full px-4 py-2.5 pl-10 bg-gray-100 dark:bg-gray-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors">
                    Search
                </button>
            </div>
        </form>
    </div>

    <!-- Workout Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($workouts as $workout)
            <div class="group bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <!-- Image -->
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $workout->image_url ?? 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400&h=300&fit=crop&auto=format' }}" 
                         alt="{{ $workout->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    
                    <!-- Status Badges -->
                    <div class="absolute top-3 left-3 flex flex-col gap-1">
                        <span class="px-3 py-1 bg-black/60 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                            {{ $workout->category }}
                        </span>
                        @if(in_array($workout->id, $completedIds ?? []))
                            <span class="px-3 py-1 bg-emerald-500/90 backdrop-blur-sm text-white text-xs font-medium rounded-full flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Completed</span>
                            </span>
                        @endif
                    </div>
                    
                    <!-- Bookmark Button -->
                    <button onclick="event.stopPropagation(); toggleBookmark({{ $workout->id }})" 
                            class="absolute top-3 right-3 p-2 bg-black/40 backdrop-blur-sm rounded-full hover:bg-emerald-500 transition-colors">
                        <svg class="w-4 h-4 text-white {{ in_array($workout->id, $bookmarkedIds ?? []) ? 'fill-current' : '' }}" 
                             fill="{{ in_array($workout->id, $bookmarkedIds ?? []) ? 'currentColor' : 'none' }}" 
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </button>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent">
                        <div class="flex items-center space-x-3 text-white text-xs">
                            <span class="flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $workout->duration }} min</span>
                            </span>
                            <span class="flex items-center space-x-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $workout->calories_burned }} cal</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5">
                    <h3 class="text-lg font-bold mb-1">{{ $workout->title }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 line-clamp-2">{{ $workout->description }}</p>
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-500/10 text-emerald-500">
                            {{ $workout->difficulty }}
                        </span>
                        <div class="flex items-center space-x-1">
                            @foreach($workout->target_muscles ?? [] as $muscle)
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $muscle }}</span>
                                @if(!$loop->last)
                                    <span class="text-xs text-gray-300 dark:text-gray-600">•</span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('workouts.show', $workout->id) }}" class="flex-1 px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white text-sm font-medium rounded-xl transition-all transform hover:scale-105 text-center">
                            View Workout
                        </a>
                        <button onclick="event.stopPropagation(); toggleBookmark({{ $workout->id }})" 
                                class="p-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-xl transition-colors">
                            <svg class="w-5 h-5 {{ in_array($workout->id, $bookmarkedIds ?? []) ? 'text-emerald-500 fill-current' : 'text-gray-600 dark:text-gray-400' }}" 
                                 fill="{{ in_array($workout->id, $bookmarkedIds ?? []) ? 'currentColor' : 'none' }}" 
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <div class="text-6xl mb-4">🏋️</div>
                <p class="text-gray-500 dark:text-gray-400">No workouts found matching your criteria.</p>
                <a href="{{ route('workouts.create') }}" class="inline-block mt-4 px-6 py-3 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors">
                    Create Your First Workout
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $workouts->links() }}
    </div>
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