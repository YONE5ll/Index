<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exercise extends Model
{
    use HasFactory;

    // Fields that can be mass-assigned (used in create/update)
    protected $fillable = [
        'name',
        'muscle_group',
        'description',
        'image_path',
    ];
}