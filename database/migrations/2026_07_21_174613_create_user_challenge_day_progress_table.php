<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_challenge_day_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('challenge_id')->constrained('challenges')->onDelete('cascade');
            $table->foreignId('challenge_day_id')->constrained('challenge_days')->onDelete('cascade');
            $table->integer('day_number');
            $table->boolean('is_completed')->default(false);
            $table->date('completed_date')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('calories_burned')->nullable();
            $table->json('exercise_results')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'challenge_id', 'day_number'], 'ucdp_unique');
            $table->index(['user_id', 'challenge_id', 'is_completed'], 'ucdp_user_challenge_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_challenge_day_progress');
    }
};