<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChallengeProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'challenge_id',
        'current_day',
        'completed_days',
        'started_at',
        'completed_at',
        'status',
        'day_completions',
        'total_calories_burned',
        'total_duration',
        'streak',
        'rating',
        'notes',
    ];

    protected $casts = [
        'day_completions' => 'array',
        'started_at' => 'date',
        'completed_at' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function dayProgress()
    {
        return $this->hasMany(UserChallengeDayProgress::class);
    }

    // Scopes
    public function scopeInProgress($query)
    {
        return $query->where('status', 1);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 2);
    }

    // Accessors
    public function getProgressPercentageAttribute()
    {
        if ($this->challenge->duration == 0) return 0;
        return round(($this->completed_days / $this->challenge->duration) * 100);
    }

    public function getDaysLeftAttribute()
    {
        return $this->challenge->duration - $this->completed_days;
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            0 => 'Not Started',
            1 => 'In Progress',
            2 => 'Completed',
            3 => 'Abandoned',
            default => 'Unknown'
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            0 => 'gray',
            1 => 'blue',
            2 => 'emerald',
            3 => 'red',
            default => 'gray'
        };
    }
}