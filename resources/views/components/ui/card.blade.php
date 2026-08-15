@props([
    'padding' => 'p-6',
    'hover' => false,
    'gradient' => false,
])

@php
    $baseClasses = 'bg-white dark:bg-gray-900 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 transition-all duration-300';
    
    if ($hover) {
        $baseClasses .= ' hover:shadow-xl hover:-translate-y-1 cursor-pointer';
    }
    
    if ($gradient) {
        $baseClasses .= ' bg-gradient-to-br from-emerald-500/5 to-blue-500/5 dark:from-emerald-500/10 dark:to-blue-500/10';
    }
@endphp

<div {{ $attributes->merge(['class' => "$baseClasses $padding"]) }}>
    {{ $slot }}
</div>