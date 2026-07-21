<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'difficulty',
        'duration',
        'calories_burned',
        'target_muscles',
        'equipment',
        'instructions',
        'image_url',
        'video_url',
        'level',
        'is_featured',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'target_muscles' => 'array',
        'equipment' => 'array',
        'instructions' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'workout_exercises')
                    ->withPivot('sets', 'reps', 'rest_seconds', 'order', 'notes')
                    ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function progress()
    {
        return $this->hasMany(UserWorkoutProgress::class);
    }

    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    // Accessors
    public function getDurationFormattedAttribute()
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        
        if ($hours > 0) {
            return "{$hours}h {$minutes}min";
        }
        return "{$minutes} min";
    }

    public function getCaloriesFormattedAttribute()
    {
        return number_format($this->calories_burned) . ' cal';
    }

    public function getExercisesCountAttribute()
    {
        return $this->exercises()->count();
    }

    public function getTotalSetsAttribute()
    {
        return $this->exercises()->sum('workout_exercises.sets');
    }
}