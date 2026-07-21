<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExerciseProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exercise_id',
        'started_at',
        'completed_at',
        'duration',
        'sets',
        'reps',
        'weight',
        'calories_burned',
        'rating',
        'notes',
        'performance_data',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'performance_data' => 'array',
        'weight' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('completed_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('completed_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    // Accessors
    public function getDurationFormattedAttribute()
    {
        if (!$this->duration) return 'N/A';
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        if ($hours > 0) {
            return "{$hours}h {$minutes}min";
        }
        return "{$minutes}min";
    }

    public function getRatingStarsAttribute()
    {
        if (!$this->rating) return '';
        return str_repeat('⭐', $this->rating);
    }
}