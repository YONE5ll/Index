<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_exercise_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->integer('duration')->nullable(); // in minutes
            $table->integer('sets')->nullable();
            $table->integer('reps')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->integer('calories_burned')->nullable();
            $table->integer('rating')->nullable(); // 1-5
            $table->text('notes')->nullable();
            $table->json('performance_data')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'exercise_id', 'completed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_exercise_progress');
    }
};