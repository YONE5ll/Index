<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FitnessPro - Transform Your Body, Transform Your Life</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-950">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-950/80 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-emerald-500 to-blue-500 bg-clip-text text-transparent">
                        Byayam
                    </span>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 dark:text-gray-300 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Features</a>
                    <a href="#how-it-works" class="text-gray-600 dark:text-gray-300 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">How It Works</a>
                    <a href="#testimonials" class="text-gray-600 dark:text-gray-300 hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Testimonials</a>

                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <button @click="darkMode = !darkMode" 
                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg x-show="!darkMode" class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:shadow-lg transition-all">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-emerald-500 transition-colors">Log in</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl hover:shadow-lg transition-all">
                                Get Started
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-4 relative overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8">
                    <div class="inline-flex items-center space-x-2 px-4 py-2 bg-emerald-500/10 rounded-full">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Trusted by 50,000+ fitness enthusiasts</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight">
                        <span class="text-gray-900 dark:text-white">Transform Your</span>
                        <span class="gradient-text">Body & Mind</span>
                    </h1>

                    <p class="text-xl text-gray-600 dark:text-gray-300 leading-relaxed">
                        Your all-in-one fitness companion. Track workouts, monitor nutrition, and achieve your goals with AI-powered insights.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold rounded-2xl shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-105">
                            Start Free Trial
                        </a>
                        <a href="#features" class="px-8 py-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-2xl hover:shadow-lg transition-all flex items-center space-x-2">
                            <span>Learn More</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                        </a>
                    </div>

                    <div class="flex items-center space-x-8 pt-4">
                        <div>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">50K+</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Active Users</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">15K+</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Workouts Completed</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-gray-900 dark:text-white">4.9★</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Average Rating</p>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Hero Image -->
                <div class="relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <div class="absolute inset-0 bg-gradient-to-tr from-emerald-500/20 to-blue-500/20"></div>
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&h=600&fit=crop&crop=center" 
                             alt="Fitness Hero" 
                             class="w-full h-[400px] object-cover rounded-3xl">
                        <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/60 to-transparent">
                            <div class="flex items-center space-x-4 text-white">
                                <div class="flex -space-x-2">
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-cover bg-center" style="background-image: url('https://ui-avatars.com/api/?name=User+1&background=10B981&color=fff&size=32')"></div>
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-cover bg-center" style="background-image: url('https://ui-avatars.com/api/?name=User+2&background=3B82F6&color=fff&size=32')"></div>
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-cover bg-center" style="background-image: url('https://ui-avatars.com/api/?name=User+3&background=F97316&color=fff&size=32')"></div>
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-700 flex items-center justify-center text-xs font-bold">+50</div>
                                </div>
                                <p class="text-sm">Join our community of fitness enthusiasts</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Badges -->
                    <div class="absolute -top-4 -right-4 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-xl animate-float">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                            <span class="text-sm font-semibold">+2.5k workouts today</span>
                        </div>
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-xl animate-float" style="animation-delay: 2s;">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-sm font-semibold">98% satisfaction rate</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4 bg-gray-50 dark:bg-gray-900/50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <span class="text-emerald-500 font-semibold text-sm uppercase tracking-wider">Features</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2">Everything You Need to Succeed</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-4 max-w-2xl mx-auto">
                    From workout tracking to nutrition planning, we've got you covered.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $features = [
                        [
                            'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z',
                            'color' => 'emerald',
                            'title' => 'Smart Workout Tracking',
                            'description' => 'Log your workouts with ease. Track sets, reps, weight, and progress over time.'
                        ],
                        [
                            'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                            'color' => 'blue',
                            'title' => 'Nutrition Tracking',
                            'description' => 'Log your meals, track calories, and maintain a balanced diet with our food database.'
                        ],
                        [
                            'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                            'color' => 'orange',
                            'title' => 'AI-Powered Coach',
                            'description' => 'Get personalized workout recommendations and form feedback from our AI coach.'
                        ],
                        [
                            'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                            'color' => 'emerald',
                            'title' => 'Progress Analytics',
                            'description' => 'Visualize your progress with detailed charts and insights. Track your transformation journey.'
                        ],
                        [
                            'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                            'color' => 'blue',
                            'title' => 'Community Challenges',
                            'description' => 'Join challenges, compete with friends, and stay motivated with our active community.'
                        ],
                        [
                            'icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
                            'color' => 'orange',
                            'title' => 'Achievement System',
                            'description' => 'Earn badges and achievements as you hit milestones. Stay motivated with gamification.'
                        ],
                    ];
                @endphp

                @foreach($features as $feature)
                    <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-200/50 dark:border-gray-800/50 group">
                        <div class="w-14 h-14 rounded-2xl bg-{{ $feature['color'] }}-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-{{ $feature['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <span class="text-emerald-500 font-semibold text-sm uppercase tracking-wider">How It Works</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2">Start Your Fitness Journey in 3 Steps</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $steps = [
                        [
                            'number' => '01',
                            'title' => 'Create Your Account',
                            'description' => 'Sign up in seconds and set up your fitness profile with your goals and preferences.',
                            'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'
                        ],
                        [
                            'number' => '02',
                            'title' => 'Track Your Progress',
                            'description' => 'Log your workouts, meals, and measurements. Get real-time insights into your progress.',
                            'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
                        ],
                        [
                            'number' => '03',
                            'title' => 'Achieve Your Goals',
                            'description' => 'Reach your fitness goals with personalized plans, AI coaching, and community support.',
                            'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
                        ]
                    ];
                @endphp

                @foreach($steps as $step)
                    <div class="relative">
                        @if(!$loop->last)
                            <div class="hidden md:block absolute top-20 left-full w-full h-0.5 bg-gradient-to-r from-emerald-500 to-blue-500 transform -translate-y-1/2" style="width: calc(100% - 2rem);"></div>
                        @endif
                        <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200/50 dark:border-gray-800/50 text-center">
                            <div class="text-6xl font-black text-emerald-500/10 dark:text-emerald-500/20 mb-4">{{ $step['number'] }}</div>
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-emerald-500/10 to-blue-500/10 flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">{{ $step['title'] }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $step['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-20 px-4 bg-gray-50 dark:bg-gray-900/50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <span class="text-emerald-500 font-semibold text-sm uppercase tracking-wider">Testimonials</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-2">What Our Users Say</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $testimonials = [
                        [
                            'name' => 'Sarah Johnson',
                            'role' => 'Marathon Runner',
                            'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Johnson&background=10B981&color=fff&size=64',
                            'content' => 'FitnessPro completely transformed my training. The AI coach helped me improve my form and prevent injuries.',
                            'rating' => 5
                        ],
                        [
                            'name' => 'Mike Chen',
                            'role' => 'Bodybuilder',
                            'avatar' => 'https://ui-avatars.com/api/?name=Mike+Chen&background=3B82F6&color=fff&size=64',
                            'content' => 'The workout tracking and nutrition features are incredible. I\'ve never been more consistent with my fitness.',
                            'rating' => 5
                        ],
                        [
                            'name' => 'Emily Rodriguez',
                            'role' => 'Yoga Instructor',
                            'avatar' => 'https://ui-avatars.com/api/?name=Emily+Rodriguez&background=F97316&color=fff&size=64',
                            'content' => 'Love the community challenges! It keeps me motivated and connected with other fitness enthusiasts.',
                            'rating' => 5
                        ]
                    ];
                @endphp

                @foreach($testimonials as $testimonial)
                    <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-200/50 dark:border-gray-800/50">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="{{ $testimonial['avatar'] }}" alt="{{ $testimonial['name'] }}" class="w-12 h-12 rounded-full">
                            <div>
                                <h4 class="font-semibold">{{ $testimonial['name'] }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $testimonial['role'] }}</p>
                            </div>
                        </div>
                        <div class="flex mb-3">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 italic">"{{ $testimonial['content'] }}"</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 bg-gradient-to-r from-emerald-500/10 via-blue-500/10 to-orange-500/10 dark:from-emerald-500/20 dark:via-blue-500/20 dark:to-orange-500/20">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Transform Your Fitness Journey?</h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">Join thousands of users who are already achieving their fitness goals</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-semibold rounded-2xl shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-105">
                    Start Your Free Trial
                </a>
                <a href="#features" class="px-8 py-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-2xl hover:shadow-lg transition-all">
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-gray-950 text-white py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold">FitnessPro</span>
                    </div>
                    <p class="text-gray-400 text-sm">Transform your body and mind with the ultimate fitness companion.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#pricing" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Integrations</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} FitnessPro. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>