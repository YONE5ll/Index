@extends('layouts.app')

@section('title', 'Community - FitnessPro')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Community</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Connect, share, and grow with fellow fitness enthusiasts</p>
        </div>
        <button class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-105">
            <span class="flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Create Post</span>
            </span>
        </button>
    </div>

    <!-- Create Post -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <div class="flex items-center space-x-3">
            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=10B981&color=fff&size=48" 
                 alt="User" 
                 class="w-12 h-12 rounded-full">
            <input type="text" 
                   placeholder="Share your fitness journey..." 
                   class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
            <button class="px-6 py-2.5 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors">
                Post
            </button>
        </div>
        <div class="flex items-center space-x-4 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 hover:text-emerald-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>Photo/Video</span>
            </button>
            <button class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 hover:text-emerald-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                <span>Check-in</span>
            </button>
        </div>
    </div>

    <!-- Feed -->
    <div class="space-y-6">
        @php
            $posts = [
                [
                    'user' => ['name' => 'Sarah Johnson', 'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=10B981&color=fff'],
                    'content' => 'Just completed my first 5k run! 🏃‍♀️ Feeling amazing and already planning my next goal. Anyone else training for a race?',
                    'image' => 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?w=800&h=400&fit=crop',
                    'likes' => 24,
                    'comments' => 8,
                    'time' => '2 hours ago',
                    'liked' => false
                ],
                [
                    'user' => ['name' => 'Mike Chen', 'avatar' => 'https://ui-avatars.com/api/?name=Mike+Chen&background=3B82F6&color=fff'],
                    'content' => 'New PR on deadlift today! 135kg x 5 reps 💪 Consistency is key!',
                    'image' => null,
                    'likes' => 18,
                    'comments' => 5,
                    'time' => '4 hours ago',
                    'liked' => true
                ],
                [
                    'user' => ['name' => 'Emma Wilson', 'avatar' => 'https://ui-avatars.com/api/?name=Emma+Wilson&background=F97316&color=fff'],
                    'content' => '30 days of yoga complete! 🧘‍♀️ The transformation in my flexibility and mental clarity is incredible. Highly recommend!',
                    'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=800&h=400&fit=crop',
                    'likes' => 42,
                    'comments' => 12,
                    'time' => '6 hours ago',
                    'liked' => false
                ],
            ];
        @endphp

        @foreach($posts as $post)
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 overflow-hidden">
                <!-- Post Header -->
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $post['user']['avatar'] }}" alt="{{ $post['user']['name'] }}" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-medium">{{ $post['user']['name'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $post['time'] }}</p>
                        </div>
                    </div>
                    <button class="p-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                    </button>
                </div>

                <!-- Post Content -->
                <div class="px-4 pb-4">
                    <p class="text-gray-800 dark:text-gray-200">{{ $post['content'] }}</p>
                </div>

                <!-- Post Image -->
                @if($post['image'])
                    <div class="px-4 pb-4">
                        <img src="{{ $post['image'] }}" alt="Post image" class="w-full rounded-xl max-h-96 object-cover">
                    </div>
                @endif

                <!-- Post Actions -->
                <div class="px-4 pb-4 flex items-center space-x-6">
                    <button class="flex items-center space-x-2 text-sm {{ $post['liked'] ? 'text-emerald-500' : 'text-gray-500 dark:text-gray-400' }} hover:text-emerald-500 transition-colors">
                        <svg class="w-5 h-5" fill="{{ $post['liked'] ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <span>{{ $post['likes'] }}</span>
                    </button>
                    <button class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 hover:text-emerald-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <span>{{ $post['comments'] }}</span>
                    </button>
                    <button class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400 hover:text-emerald-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        <span>Share</span>
                    </button>
                </div>

                <!-- Comments Section -->
                <div class="px-4 pb-4 pt-2 border-t border-gray-200/50 dark:border-gray-800/50">
                    <div class="flex items-center space-x-2">
                        <input type="text" 
                               placeholder="Write a comment..." 
                               class="flex-1 px-3 py-1.5 bg-gray-50 dark:bg-gray-800 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                        <button class="px-4 py-1.5 bg-emerald-500 text-white text-sm rounded-lg hover:bg-emerald-600 transition-colors">
                            Post
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Groups & Leaderboard -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Groups -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="font-semibold mb-4">Popular Groups</h3>
            <div class="space-y-3">
                @php
                    $groups = [
                        ['name' => 'HIIT Warriors', 'members' => 234, 'image' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400&h=200&fit=crop'],
                        ['name' => 'Yoga Enthusiasts', 'members' => 189, 'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=400&h=200&fit=crop'],
                        ['name' => 'Strength Training', 'members' => 321, 'image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=400&h=200&fit=crop'],
                    ];
                @endphp
                @foreach($groups as $group)
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors cursor-pointer">
                        <img src="{{ $group['image'] }}" alt="{{ $group['name'] }}" class="w-12 h-12 rounded-lg object-cover">
                        <div class="flex-1">
                            <p class="font-medium">{{ $group['name'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $group['members'] }} members</p>
                        </div>
                        <button class="px-3 py-1.5 text-sm bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                            Join
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Leaderboard -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
            <h3 class="font-semibold mb-4">Leaderboard</h3>
            <div class="space-y-3">
                @php
                    $leaders = [
                        ['rank' => 1, 'name' => 'Mike Chen', 'points' => 2850, 'avatar' => 'https://ui-avatars.com/api/?name=Mike+Chen&background=F97316&color=fff', 'badge' => '🥇'],
                        ['rank' => 2, 'name' => 'Emma Wilson', 'points' => 2700, 'avatar' => 'https://ui-avatars.com/api/?name=Emma+Wilson&background=10B981&color=fff', 'badge' => '🥈'],
                        ['rank' => 3, 'name' => 'David Kim', 'points' => 2550, 'avatar' => 'https://ui-avatars.com/api/?name=David+Kim&background=3B82F6&color=fff', 'badge' => '🥉'],
                        ['rank' => 4, 'name' => 'Lisa Park', 'points' => 2400, 'avatar' => 'https://ui-avatars.com/api/?name=Lisa+Park&background=8B5CF6&color=fff', 'badge' => '4'],
                        ['rank' => 5, 'name' => 'James Brown', 'points' => 2250, 'avatar' => 'https://ui-avatars.com/api/?name=James+Brown&background=EC4899&color=fff', 'badge' => '5'],
                    ];
                @endphp
                @foreach($leaders as $leader)
                    <div class="flex items-center space-x-3 p-2 {{ $leader['rank'] <= 3 ? 'bg-gradient-to-r from-amber-50 to-transparent dark:from-amber-900/10' : '' }} rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <span class="text-xl font-bold w-8">{{ $leader['badge'] }}</span>
                        <img src="{{ $leader['avatar'] }}" alt="{{ $leader['name'] }}" class="w-8 h-8 rounded-full">
                        <div class="flex-1">
                            <p class="font-medium text-sm">{{ $leader['name'] }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $leader['points'] }} points</p>
                        </div>
                        @if($leader['rank'] <= 3)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                Top {{ $leader['rank'] }}
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection