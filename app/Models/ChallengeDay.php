<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'day_number',
        'workout_name',
        'exercises',
        'sets',
        'reps',
        'estimated_calories',
        'estimated_duration',
        'notes',
    ];

    protected $casts = [
        'exercises' => 'array',
    ];

    // Relationships
    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserChallengeDayProgress::class);
    }

    // Accessors
    public function getIsCompletedAttribute()
    {
        if (!auth()->check()) return false;
        return $this->userProgress()
            ->where('user_id', auth()->id())
            ->where('is_completed', true)
            ->exists();
    }

    public function getUserProgressAttribute()
    {
        if (!auth()->check()) return null;
        return $this->userProgress()
            ->where('user_id', auth()->id())
            ->first();
    }
}