@extends('layouts.app')

@section('title', 'Profile - FitnessPro')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold">My Profile</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your personal information and fitness goals</p>
    </div>

    <!-- Profile Card -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 overflow-hidden">
        <!-- Cover Image -->
        <div class="h-32 bg-gradient-to-r from-emerald-500 via-blue-500 to-orange-500 relative">
            <div class="absolute -bottom-12 left-8">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=10B981&color=fff&size=128" 
                         alt="Profile" 
                         class="w-24 h-24 rounded-full border-4 border-white dark:border-gray-900">
                    <button class="absolute bottom-0 right-0 p-1.5 bg-emerald-500 rounded-full text-white hover:bg-emerald-600 transition-colors border-2 border-white dark:border-gray-900">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Profile Info -->
        <div class="pt-14 px-8 pb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold">{{ Auth::user()->name ?? 'John Doe' }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">{{ Auth::user()->email ?? 'john@example.com' }}</p>
                    <p class="text-sm text-emerald-500 font-semibold mt-1">Member since {{ Auth::user()->created_at->format('F Y') ?? 'January 2024' }}</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-center px-4 py-2 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-sm text-gray-500 dark:text-gray-400">BMI</p>
                        <p class="text-lg font-bold text-emerald-500">22.4</p>
                    </div>
                    <div class="text-center px-4 py-2 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Body Fat</p>
                        <p class="text-lg font-bold text-blue-500">15.2%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <h3 class="text-xl font-bold mb-6">Personal Information</h3>
        <form class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                    <input type="text" value="{{ Auth::user()->name ?? 'John Doe' }}" 
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                    <input type="email" value="{{ Auth::user()->email ?? 'john@example.com' }}" 
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Age</label>
                    <input type="number" placeholder="25" 
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
                    <select class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Height (cm)</label>
                    <input type="number" placeholder="175" 
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Weight (kg)</label>
                    <input type="number" placeholder="75" 
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fitness Goal</label>
                    <select class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                        <option>Build Muscle</option>
                        <option>Lose Weight</option>
                        <option>Maintain Fitness</option>
                        <option>Increase Strength</option>
                        <option>Improve Endurance</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Activity Level</label>
                    <select class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                        <option>Sedentary</option>
                        <option>Lightly Active</option>
                        <option selected>Moderately Active</option>
                        <option>Very Active</option>
                        <option>Extra Active</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Medical Notes</label>
                <textarea rows="3" placeholder="Any medical conditions, injuries, or notes..." 
                          class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all"></textarea>
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-105">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection