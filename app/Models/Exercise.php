<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'body_part',
        'difficulty',
        'equipment',
        'muscle_groups',
        'instructions',
        'image_url',
        'video_url',
        'calories_per_hour',
        'is_active',
    ];

    protected $casts = [
        'equipment' => 'array',
        'muscle_groups' => 'array',
        'instructions' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function workouts()
    {
        return $this->belongsToMany(Workout::class, 'workout_exercises')
                    ->withPivot('sets', 'reps', 'rest_seconds', 'order', 'notes')
                    ->withTimestamps();
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

    public function scopeByBodyPart($query, $bodyPart)
    {
        return $query->where('body_part', $bodyPart);
    }

    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    // Accessors
    public function getEquipmentListAttribute()
    {
        return is_array($this->equipment) ? implode(', ', $this->equipment) : '';
    }

    public function getMuscleGroupsListAttribute()
    {
        return is_array($this->muscle_groups) ? implode(', ', $this->muscle_groups) : '';
    }
}