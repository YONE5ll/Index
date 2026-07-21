@props([
    'id',
    'maxWidth' => '2xl',
])

@php
    $maxWidths = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
    ];
@endphp

<div x-data="{ open: false }" 
     x-init="$watch('open', value => {
         if (value) {
             document.body.style.overflow = 'hidden';
         } else {
             document.body.style.overflow = '';
         }
     })"
     x-on:keydown.escape.window="open = false"
     x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: none;">
    
    <div class="min-h-screen px-4 text-center">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="open = false"></div>
        
        <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>
        
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="inline-block w-full {{ $maxWidths[$maxWidth] }} p-6 my-8 text-left align-middle bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200/50 dark:border-gray-800/50 transform transition-all">
            
            {{ $slot }}
        </div>
    </div>
</div>