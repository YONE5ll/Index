@extends('layouts.app')

@section('title', 'Nutrition - FitnessPro')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold">Nutrition Tracking</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Track your daily nutrition and stay on target</p>
    </div>

    <!-- Daily Summary -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $macros = [
                ['label' => 'Calories', 'consumed' => 1845, 'target' => 2200, 'color' => 'emerald', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Protein', 'consumed' => 125, 'target' => 150, 'color' => 'blue', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['label' => 'Carbs', 'consumed' => 220, 'target' => 250, 'color' => 'orange', 'icon' => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9'],
                ['label' => 'Fat', 'consumed' => 45, 'target' => 65, 'color' => 'blue', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
            ];
        @endphp

        @foreach($macros as $macro)
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $macro['label'] }}</span>
                    <div class="w-7 h-7 rounded-lg bg-{{ $macro['color'] }}-500/10 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-{{ $macro['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $macro['icon'] }}"/>
                        </svg>
                    </div>
                </div>
                <div class="text-lg font-bold">{{ $macro['consumed'] }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">Target: {{ $macro['target'] }}</div>
                <div class="mt-2 h-1.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-{{ $macro['color'] }}-500 to-{{ $macro['color'] }}-400 rounded-full transition-all duration-1000" 
                         style="width: {{ ($macro['consumed'] / $macro['target']) * 100 }}%"></div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Water Tracker -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-semibold">Water Intake</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">1.8L / 3.0L</p>
            </div>
            <div class="flex items-center space-x-2">
                <button class="p-2 bg-blue-500/10 text-blue-500 rounded-lg hover:bg-blue-500/20 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
                <button class="p-2 bg-blue-500/10 text-blue-500 rounded-lg hover:bg-blue-500/20 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            @for($i = 0; $i < 8; $i++)
                <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full {{ $i < 4 ? 'w-full' : 'w-0' }}"></div>
                </div>
            @endfor
        </div>
        <div class="flex justify-between mt-2 text-xs text-gray-500 dark:text-gray-400">
            <span>0L</span>
            <span>3L</span>
        </div>
    </div>

    <!-- Meals -->
    <div>
        <h2 class="text-xl font-bold mb-4">Today's Meals</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $meals = [
                    ['name' => 'Breakfast', 'foods' => ['Oatmeal', 'Banana', 'Greek Yogurt'], 'calories' => 355, 'color' => 'emerald'],
                    ['name' => 'Lunch', 'foods' => ['Chicken Salad', 'Quinoa'], 'calories' => 570, 'color' => 'blue'],
                    ['name' => 'Dinner', 'foods' => ['Grilled Salmon', 'Vegetables', 'Brown Rice'], 'calories' => 620, 'color' => 'orange'],
                    ['name' => 'Snacks', 'foods' => ['Apple', 'Almonds'], 'calories' => 300, 'color' => 'purple'],
                ];
            @endphp

            @foreach($meals as $meal)
                <div class="bg-white dark:bg-gray-900 rounded-2xl p-4 border border-gray-200/50 dark:border-gray-800/50 hover:shadow-lg transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold">{{ $meal['name'] }}</h4>
                        <span class="text-sm font-medium text-{{ $meal['color'] }}-500">{{ $meal['calories'] }} cal</span>
                    </div>
                    <ul class="space-y-1">
                        @foreach($meal['foods'] as $food)
                            <li class="text-sm text-gray-600 dark:text-gray-400 flex items-center space-x-2">
                                <svg class="w-3 h-3 text-{{ $meal['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>{{ $food }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <button class="mt-3 w-full text-sm text-{{ $meal['color'] }}-500 hover:text-{{ $meal['color'] }}-600 font-medium transition-colors">
                        + Add Food
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Food Search -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <h3 class="font-semibold mb-4">Search Food</h3>
        <div class="flex items-center space-x-3">
            <div class="flex-1 relative">
                <input type="text" 
                       placeholder="Search for foods..." 
                       class="w-full px-4 py-2.5 pl-10 bg-gray-100 dark:bg-gray-800 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <button class="px-6 py-2.5 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-colors">
                Search
            </button>
        </div>
        <div class="mt-4 space-y-2">
            @php
                $recentFoods = [
                    ['name' => 'Chicken Breast', 'calories' => 165, 'protein' => 31, 'carbs' => 0, 'fat' => 3.6],
                    ['name' => 'Brown Rice', 'calories' => 216, 'protein' => 5, 'carbs' => 45, 'fat' => 1.8],
                    ['name' => 'Salmon', 'calories' => 208, 'protein' => 22, 'carbs' => 0, 'fat' => 13],
                ];
            @endphp
            @foreach($recentFoods as $food)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    <div>
                        <p class="font-medium">{{ $food['name'] }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $food['calories'] }} cal • P: {{ $food['protein'] }}g • C: {{ $food['carbs'] }}g • F: {{ $food['fat'] }}g
                        </p>
                    </div>
                    <button class="px-3 py-1.5 bg-emerald-500 text-white text-sm rounded-lg hover:bg-emerald-600 transition-colors">
                        Log
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Nutrition Chart -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <h3 class="font-semibold mb-4">Weekly Nutrition</h3>
        <div class="h-64 flex items-end justify-between space-x-2">
            @php
                $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                $calories = [1800, 2100, 1950, 2200, 2050, 2400, 1900];
                $protein = [120, 150, 130, 145, 140, 160, 125];
            @endphp
            @foreach($days as $index => $day)
                <div class="flex-1 flex flex-col items-center">
                    <div class="w-full flex flex-col items-center space-y-1">
                        <div class="w-full bg-blue-500/20 rounded-t-lg transition-all duration-500 hover:bg-blue-500/30"
                             style="height: {{ ($protein[$index] / 200) * 100 }}%"></div>
                        <div class="w-full bg-emerald-500/20 rounded-t-lg transition-all duration-500 hover:bg-emerald-500/30"
                             style="height: {{ ($calories[$index] / 2500) * 100 }}%"></div>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ $day }}</span>
                </div>
            @endforeach
        </div>
        <div class="flex justify-center space-x-4 mt-4">
            <span class="flex items-center space-x-2 text-sm">
                <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                <span class="text-gray-600 dark:text-gray-400">Calories</span>
            </span>
            <span class="flex items-center space-x-2 text-sm">
                <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                <span class="text-gray-600 dark:text-gray-400">Protein</span>
            </span>
        </div>
    </div>
</div>
@endsection