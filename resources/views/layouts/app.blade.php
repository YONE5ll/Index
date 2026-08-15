<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data 
      x-init="$watch('$store.darkMode.on', val => {
          document.documentElement.classList.toggle('dark', val);
          localStorage.setItem('darkMode', val);
      })"
      :class="$store.darkMode.on ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'FitnessPro'))</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <!-- Main Container - Flex with sidebar -->
    <div class="flex min-h-screen">
        <!-- Sidebar - Fixed position -->
        @include('layouts.sidebar')

        <!-- Main Content Area - This takes the remaining space -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Top Navigation -->
            @include('components.navigation.navbar')
            
            <!-- Page Content -->
            <main class="flex-1 p-4 md:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>