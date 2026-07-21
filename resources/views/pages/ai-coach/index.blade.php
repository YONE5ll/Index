@extends('layouts.app')

@section('title', 'AI Coach - FitnessPro')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold">AI Fitness Coach</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Get personalized guidance and advice from your AI fitness assistant</p>
    </div>

    <!-- Chat Interface -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 overflow-hidden h-[600px] flex">
        <!-- Conversation List - Left Sidebar -->
        <div class="w-64 border-r border-gray-200/50 dark:border-gray-800/50 hidden md:flex flex-col">
            <div class="p-4 border-b border-gray-200/50 dark:border-gray-800/50">
                <button class="w-full px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl text-sm font-medium hover:from-emerald-600 hover:to-emerald-700 transition-all">
                    <span class="flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>New Chat</span>
                    </span>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-2 space-y-1">
                @php
                    $conversations = [
                        ['id' => 1, 'title' => 'Workout Plan Help', 'last' => 'Can you help me with a workout plan?', 'time' => '2h ago', 'active' => true],
                        ['id' => 2, 'title' => 'Nutrition Advice', 'last' => 'What should I eat after a workout?', 'time' => 'Yesterday', 'active' => false],
                        ['id' => 3, 'title' => 'Form Check', 'last' => 'Is my squat form correct?', 'time' => '3d ago', 'active' => false],
                        ['id' => 4, 'title' => 'Motivation Tips', 'last' => 'How to stay motivated?', 'time' => '5d ago', 'active' => false],
                    ];
                @endphp
                @foreach($conversations as $conv)
                    <div class="px-3 py-2 rounded-xl cursor-pointer transition-colors {{ $conv['active'] ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        <p class="text-sm font-medium truncate">{{ $conv['title'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $conv['last'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $conv['time'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Chat Window - Right Side -->
        <div class="flex-1 flex flex-col">
            <!-- Chat Header -->
            <div class="p-4 border-b border-gray-200/50 dark:border-gray-800/50 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-500 to-blue-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">AI Coach</p>
                        <p class="text-xs text-green-500 flex items-center space-x-1">
                            <span class="w-2 h-2 bg-green-500 rounded-full inline-block"></span>
                            <span>Online</span>
                        </p>
                    </div>
                </div>
                <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                    </svg>
                </button>
            </div>

            <!-- Chat Messages -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                <!-- AI Message -->
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-500 to-blue-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl rounded-tl-none px-4 py-3 max-w-2xl">
                            <p class="text-sm text-gray-800 dark:text-gray-200">Hello! I'm your AI fitness coach. How can I help you today? I can assist with workout plans, nutrition advice, form tips, and more!</p>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Just now</p>
                    </div>
                </div>

                <!-- User Message -->
                <div class="flex items-start space-x-3 flex-row-reverse">
                    <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-sm font-bold">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="bg-emerald-500 rounded-2xl rounded-tr-none px-4 py-3 max-w-2xl ml-auto">
                            <p class="text-sm text-white">Can you help me create a workout plan for beginners?</p>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 text-right">2 min ago</p>
                    </div>
                </div>

                <!-- AI Response -->
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-500 to-blue-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl rounded-tl-none px-4 py-3 max-w-2xl">
                            <p class="text-sm text-gray-800 dark:text-gray-200">Absolutely! Here's a great beginner workout plan to get you started:</p>
                            <div class="mt-2 space-y-1 text-sm text-gray-700 dark:text-gray-300">
                                <p>🏋️ <strong>Monday & Thursday</strong> - Upper Body</p>
                                <p class="ml-4">• Push-ups (3 sets x 10 reps)</p>
                                <p class="ml-4">• Dumbbell Rows (3 sets x 12 reps)</p>
                                <p class="ml-4">• Shoulder Press (3 sets x 12 reps)</p>
                                <p class="mt-1">🏋️ <strong>Tuesday & Friday</strong> - Lower Body</p>
                                <p class="ml-4">• Squats (3 sets x 15 reps)</p>
                                <p class="ml-4">• Lunges (3 sets x 12 reps each leg)</p>
                                <p class="ml-4">• Calf Raises (3 sets x 20 reps)</p>
                                <p class="mt-1">🌿 <strong>Wednesday & Saturday</strong> - Active Recovery</p>
                                <p class="ml-4">• 30 min walking or light yoga</p>
                                <p class="mt-2 text-emerald-500">💡 Tip: Start with lighter weights and focus on form!</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">1 min ago</p>
                    </div>
                </div>

                <!-- Typing Animation -->
                <div class="flex items-start space-x-3 animate-pulse">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-emerald-500 to-blue-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl rounded-tl-none px-4 py-3 max-w-2xl">
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="p-4 border-t border-gray-200/50 dark:border-gray-800/50">
                <div class="flex items-center space-x-3">
                    <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                        </svg>
                    </button>
                    <input type="text" 
                           placeholder="Type your message..." 
                           class="flex-1 px-4 py-2.5 bg-gray-100 dark:bg-gray-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    <button class="p-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:from-emerald-600 hover:to-emerald-700 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </div>

                <!-- Suggested Prompts -->
                <div class="flex flex-wrap gap-2 mt-3">
                    @php
                        $prompts = [
                            'Create a workout plan for me',
                            'How to improve my form?',
                            'Best post-workout meal',
                            'Tips for better sleep'
                        ];
                    @endphp
                    @foreach($prompts as $prompt)
                        <button class="px-3 py-1 text-xs bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-full transition-colors text-gray-600 dark:text-gray-400">
                            {{ $prompt }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection