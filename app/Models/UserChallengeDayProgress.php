<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChallengeDayProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'challenge_id',
        'challenge_day_id',
        'day_number',
        'is_completed',
        'completed_date',
        'duration',
        'calories_burned',
        'exercise_results',
        'notes',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_date' => 'date',
        'exercise_results' => 'array',
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

    public function challengeDay()
    {
        return $this->belongsTo(ChallengeDay::class);
    }
}