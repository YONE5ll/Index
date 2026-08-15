@extends('layouts.guest')

@section('title', 'Reset Password - FitnessPro')

@section('content')
<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-8 border border-gray-200/50 dark:border-gray-800/50">
    <div class="text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/25">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Reset Password</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">
            Enter your email address and we'll send you a link to reset your password.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-600 dark:text-emerald-400 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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

        <!-- Submit -->
        <button type="submit" 
                class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl shadow-lg shadow-blue-500/25 transition-all transform hover:scale-[1.02]">
            Send Reset Link
        </button>
    </form>

    <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
        Remember your password? 
        <a href="{{ route('login') }}" class="text-emerald-500 hover:text-emerald-600 font-medium transition-colors">
            Sign in
        </a>
    </p>
</div>
@endsection