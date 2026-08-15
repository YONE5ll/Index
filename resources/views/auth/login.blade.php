@extends('layouts.guest')

@section('title', 'Login - FitnessPro')

@section('content')
<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-8 border border-gray-200/50 dark:border-gray-800/50">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-r from-emerald-500 to-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-500/25">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome Back</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Sign in to continue your fitness journey</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Email Address
            </label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}"
                   required 
                   autofocus
                   class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all @error('email') border-red-500 @enderror"
                   placeholder="you@example.com">
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Password
            </label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   required
                   class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all @error('password') border-red-500 @enderror"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label class="flex items-center space-x-2">
                <input type="checkbox" 
                       name="remember" 
                       class="w-4 h-4 text-emerald-500 border-gray-300 dark:border-gray-700 rounded focus:ring-emerald-500">
                <span class="text-sm text-gray-600 dark:text-gray-400">Remember me</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-sm text-emerald-500 hover:text-emerald-600 transition-colors">
                Forgot password?
            </a>
        </div>

        <!-- Submit -->
        <button type="submit" 
                class="w-full py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-[1.02]">
            Sign In
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
        Don't have an account? 
        <a href="{{ route('register') }}" class="text-emerald-500 hover:text-emerald-600 font-medium transition-colors">
            Create one
        </a>
    </p>
</div>
@endsection