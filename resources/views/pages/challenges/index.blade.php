@extends('layouts.app')

@section('title', 'Challenges - Byayam')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Challenges</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Push your limits and earn rewards</p>
        </div>
        <div class="flex items-center space-x-3">
            <select onchange="window.location.href=this.value" 
                    class="px-4 py-2.5 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                <option value="{{ route('challenges.index') }}">All Challenges</option>
                <option value="{{ route('challenges.index', ['difficulty' => 'Beginner']) }}">Beginner</option>
                <option value="{{ route('challenges.index', ['difficulty' => 'Intermediate']) }}">Intermediate</option>
                <option value="{{ route('challenges.index', ['difficulty' => 'Advanced']) }}">Advanced</option>
            </select>
        </div>
    </div>

    <!-- Active Challenges -->
    @if($userChallenges->count() > 0)
        <div>
            <h2 class="text-xl font-bold mb-4">Your Active Challenges</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($userChallenges as $userChallenge)
                    @php
                        $challenge = $userChallenge->challenge;
                        $progress = $userChallenge->progress_percentage;
                        $daysLeft = $userChallenge->days_left;
                    @endphp
                    <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50 hover:shadow-xl transition-all">
                        <div class="relative h-40">
                            <img src="{{ $challenge->image_url ?? 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400&h=300&fit=crop&auto=format' }}" 
                                 alt="{{ $challenge->name }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-3 left-3 right-3">
                                <h3 class="text-white font-bold">{{ $challenge->name }}</h3>
                                <div class="flex items-center space-x-3 text-white/80 text-sm">
                                    <span>{{ $progress }}% complete</span>
                                    <span>•</span>
                                    <span>{{ $daysLeft }} days left</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full transition-all duration-1000" 
                                     style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $progress }}% completed</span>
                                <a href="{{ route('challenges.show', $challenge->id) }}" 
                                   class="px-4 py-1.5 text-sm bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                                    Continue
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Available Challenges -->
    <div>
        <h2 class="text-xl font-bold mb-4">Available Challenges</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($challenges as $challenge)
                @if(!$challenge->is_joined)
                    <div class="group bg-white dark:bg-gray-900 rounded-2xl overflow-hidden border border-gray-200/50 dark:border-gray-800/50 hover:shadow-xl transition-all hover:-translate-y-1">
                        <div class="relative h-48">
                            <img src="{{ $challenge->image_url ?? 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400&h=300&fit=crop&auto=format' }}" 
                                 alt="{{ $challenge->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @if($challenge->is_featured)
                                <div class="absolute top-3 right-3 px-3 py-1 bg-gradient-to-r from-emerald-500 to-blue-500 text-white text-xs font-medium rounded-full">
                                    Featured
                                </div>
                            @endif
                            <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent">
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-{{ $challenge->color ?? 'emerald' }}-500/90 text-white">
                                    {{ $challenge->difficulty }}
                                </span>
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold mb-1">{{ $challenge->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($challenge->description, 80) }}</p>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">⏱️ {{ $challenge->duration }} days</span>
                                <span class="text-gray-500 dark:text-gray-400">👥 {{ $challenge->participants }}</span>
                            </div>
                            <form action="{{ route('challenges.join', $challenge->id) }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl transition-all transform hover:scale-105">
                                    Join Challenge
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-span-3 text-center py-12">
                    <div class="text-6xl mb-4">🏆</div>
                    <p class="text-gray-500 dark:text-gray-400">No challenges available at the moment.</p>
                    <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">Check back soon for new challenges!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $challenges->links() }}
    </div>
</div>
@endsection