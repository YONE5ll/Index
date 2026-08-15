<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenge_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained('challenges')->onDelete('cascade');
            $table->integer('day_number');
            $table->string('workout_name');
            $table->json('exercises');
            $table->integer('sets')->default(3);
            $table->string('reps')->default('10-12');
            $table->integer('estimated_calories')->nullable();
            $table->integer('estimated_duration')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['challenge_id', 'day_number'], 'cd_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge_days');
    }
};