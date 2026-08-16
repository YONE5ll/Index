@extends('layouts.app')

@section('title', 'Create Workout - Byayam')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold">Create New Workout</h1>
        <a href="{{ route('workouts.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-emerald-500 transition-colors">
            Back to Workouts
        </a>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-800/50">
        <form method="POST" action="{{ route('workouts.store') }}" class="space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required 
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all"
                           placeholder="e.g., Full Body Strength">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category <span class="text-red-500">*</span></label>
                    <select name="category" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                        <option value="">Select Category</option>
                        <option value="Strength">Strength</option>
                        <option value="Hypertrophy">Hypertrophy</option>
                        <option value="Powerlifting">Powerlifting</option>
                        <option value="Calisthenics">Calisthenics</option>
                        <option value="Yoga">Yoga</option>
                        <option value="HIIT">HIIT</option>
                        <option value="Cardio">Cardio</option>
                        <option value="CrossFit">CrossFit</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Difficulty <span class="text-red-500">*</span></label>
                    <select name="difficulty" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                        <option value="">Select Difficulty</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                    @error('difficulty')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Duration (minutes) <span class="text-red-500">*</span></label>
                    <input type="number" name="duration" required min="1"
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all"
                           placeholder="e.g., 45">
                    @error('duration')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Calories Burned <span class="text-red-500">*</span></label>
                    <input type="number" name="calories_burned" required min="0"
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all"
                           placeholder="e.g., 320">
                    @error('calories_burned')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image URL</label>
                    <input type="url" name="image_url"
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all"
                           placeholder="https://example.com/image.jpg">
                    @error('image_url')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" required rows="4"
                          class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all"
                          placeholder="Describe the workout..."></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Target Muscles -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Muscles <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @php
                        $muscles = ['Chest', 'Back', 'Legs', 'Shoulders', 'Core', 'Arms', 'Glutes', 'Hamstrings', 'Quadriceps', 'Calves', 'Biceps', 'Triceps'];
                    @endphp
                    @foreach($muscles as $muscle)
                        <label class="flex items-center space-x-2 p-2 bg-gray-50 dark:bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <input type="checkbox" name="target_muscles[]" value="{{ $muscle }}"
                                   class="w-4 h-4 text-emerald-500 border-gray-300 rounded focus:ring-emerald-500">
                            <span class="text-sm">{{ $muscle }}</span>
                        </label>
                    @endforeach
                </div>
                @error('target_muscles')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Equipment -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Equipment</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @php
                        $equipment = ['Barbell', 'Dumbbells', 'Bench', 'Pull-up Bar', 'Kettlebell', 'Resistance Bands', 'Medicine Ball', 'Jump Rope', 'Bodyweight', 'Cable Machine', 'Leg Press Machine', 'Squat Rack'];
                    @endphp
                    @foreach($equipment as $item)
                        <label class="flex items-center space-x-2 p-2 bg-gray-50 dark:bg-gray-800 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <input type="checkbox" name="equipment[]" value="{{ $item }}"
                                   class="w-4 h-4 text-emerald-500 border-gray-300 rounded focus:ring-emerald-500">
                            <span class="text-sm">{{ $item }}</span>
                        </label>
                    @endforeach
                </div>
                @error('equipment')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Exercises Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Exercises <span class="text-red-500">*</span></label>
                <div class="space-y-3" id="exercisesContainer">
                    <div class="exercise-entry flex items-center space-x-3">
                        <select name="exercises[0][id]" required class="flex-1 px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                            <option value="">Select Exercise</option>
                            @foreach($exercises as $exercise)
                                <option value="{{ $exercise->id }}">{{ $exercise->name }} ({{ $exercise->body_part }})</option>
                            @endforeach
                        </select>
                        <input type="number" name="exercises[0][sets]" placeholder="Sets" required min="1" class="w-20 px-3 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                        <input type="text" name="exercises[0][reps]" placeholder="Reps" required class="w-24 px-3 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                        <input type="number" name="exercises[0][rest]" placeholder="Rest (sec)" class="w-24 px-3 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
                        <button type="button" onclick="removeExercise(this)" class="p-2 text-red-500 hover:text-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <button type="button" onclick="addExercise()" class="mt-3 px-4 py-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-xl transition-colors text-sm font-medium">
                    + Add Exercise
                </button>
                @error('exercises')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Instructions -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Instructions</label>
                <textarea name="instructions" rows="3"
                          class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all"
                          placeholder="Step-by-step instructions..."></textarea>
                @error('instructions')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('workouts.index') }}" class="px-6 py-3 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-xl transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg shadow-emerald-500/25 transition-all transform hover:scale-105">
                    Create Workout
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let exerciseCount = 1;

function addExercise() {
    const container = document.getElementById('exercisesContainer');
    const entry = document.createElement('div');
    entry.className = 'exercise-entry flex items-center space-x-3';
    entry.innerHTML = `
        <select name="exercises[${exerciseCount}][id]" required class="flex-1 px-4 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
            <option value="">Select Exercise</option>
            @foreach($exercises as $exercise)
                <option value="{{ $exercise->id }}">{{ $exercise->name }} ({{ $exercise->body_part }})</option>
            @endforeach
        </select>
        <input type="number" name="exercises[${exerciseCount}][sets]" placeholder="Sets" required min="1" class="w-20 px-3 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
        <input type="text" name="exercises[${exerciseCount}][reps]" placeholder="Reps" required class="w-24 px-3 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
        <input type="number" name="exercises[${exerciseCount}][rest]" placeholder="Rest (sec)" class="w-24 px-3 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 transition-all">
        <button type="button" onclick="removeExercise(this)" class="p-2 text-red-500 hover:text-red-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;
    container.appendChild(entry);
    exerciseCount++;
}

function removeExercise(button) {
    const container = document.getElementById('exercisesContainer');
    if (container.children.length <= 1) {
        alert('You need at least one exercise.');
        return;
    }
    button.parentElement.remove();
}
</script>
@endpush
@endsection