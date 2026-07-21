<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'difficulty',
        'duration',
        'participants',
        'image_url',
        'color',
        'is_featured',
        'is_active',
        'requirements',
        'rewards',
    ];

    protected $casts = [
        'requirements' => 'array',
        'rewards' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function days()
    {
        return $this->hasMany(ChallengeDay::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserChallengeProgress::class);
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

    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    // Accessors
    public function getProgressAttribute()
    {
        return $this->userProgress()
            ->where('user_id', auth()->id())
            ->first();
    }

    public function getIsJoinedAttribute()
    {
        return $this->userProgress()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function getCompletionRateAttribute()
    {
        if (!$this->is_joined) return 0;
        $progress = $this->userProgress()
            ->where('user_id', auth()->id())
            ->first();
        return $progress ? round(($progress->completed_days / $this->duration) * 100) : 0;
    }

    public function getTotalDaysCompletedAttribute()
    {
        $progress = $this->userProgress()
            ->where('user_id', auth()->id())
            ->first();
        return $progress ? $progress->completed_days : 0;
    }
}