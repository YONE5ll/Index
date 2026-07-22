@extends('layouts.app')

@section('title', 'Settings - FitnessPro')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold">Settings</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Customize your app experience</p>
    </div>

    <!-- Theme Settings -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 p-6">
        <h3 class="font-semibold mb-4">Appearance</h3>
        <div class="flex items-center justify-between">
            <div>
                <p class="font-medium">Dark Mode</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Switch between light and dark themes</p>
            </div>
            <button @click="$store.darkMode.toggle()" 
                    class="relative w-14 h-8 bg-gray-300 dark:bg-emerald-500 rounded-full transition-colors duration-300">
                <span class="absolute top-1 left-1 w-6 h-6 bg-white rounded-full transition-transform duration-300 shadow-md"
                      :class="$store.darkMode.on ? 'translate-x-6' : 'translate-x-0'"></span>
            </button>
        </div>
    </div>

    <!-- Notification Settings -->
    <!-- <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 p-6">
        <h3 class="font-semibold mb-4">Notifications</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium">Email Notifications</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Receive updates and reminders via email</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium">Workout Reminders</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Get reminded about your scheduled workouts</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium">Achievement Alerts</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Celebrate when you unlock new achievements</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>
        </div>
    </div> -->

    <!-- Language & Units -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 p-6">
            <h3 class="font-semibold mb-4">Language</h3>
            <select class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                <option>English</option>
                <option>Spanish</option>
                <option>French</option>
                <option>German</option>
            </select>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 p-6">
            <h3 class="font-semibold mb-4">Units</h3>
            <select class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                <option>Metric (kg, cm)</option>
                <option>Imperial (lb, ft)</option>
            </select>
        </div>
    </div>

    <!-- Privacy & Security -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 p-6">
        <h3 class="font-semibold mb-4">Privacy & Security</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium">Profile Privacy</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Who can see your profile and progress</p>
                </div>
                <select class="px-4 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                    <option>Public</option>
                    <option selected>Friends Only</option>
                    <option>Private</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium">Change Password</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Update your account password</p>
                </div>
                <button class="px-6 py-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-xl transition-colors font-medium">
                    Change
                </button>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium">Two-Factor Authentication</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Add an extra layer of security</p>
                </div>
                <button class="px-6 py-2 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors font-medium">
                    Enable
                </button>
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="bg-red-50 dark:bg-red-900/10 rounded-2xl border border-red-200 dark:border-red-800/30 p-6">
        <h3 class="font-semibold text-red-600 dark:text-red-400 mb-4">Danger Zone</h3>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <p class="font-medium text-red-600 dark:text-red-400">Delete Account</p>
                <p class="text-sm text-red-600/70 dark:text-red-400/70">Permanently delete your account and all data</p>
            </div>
            <button class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl shadow-lg shadow-red-500/25 transition-all transform hover:scale-105">
                Delete Account
            </button>
        </div>
        <p class="text-xs text-red-600/60 dark:text-red-400/60 mt-3">This action is irreversible. All your data will be permanently deleted.</p>
    </div>
</div>
@endsection