<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Routine extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
    ];

    // A routine belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A routine has many exercises, through the pivot table
    // withPivot lets us access sets/reps/order_index on each exercise
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'routine_exercises')
                    ->withPivot('sets', 'reps', 'order_index')
                    ->withTimestamps()
                    ->orderBy('routine_exercises.order_index');
    }
}