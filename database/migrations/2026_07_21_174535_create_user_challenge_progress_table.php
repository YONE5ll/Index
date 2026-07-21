<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_challenge_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('challenge_id')->constrained('challenges')->onDelete('cascade');
            $table->integer('current_day')->default(0);
            $table->integer('completed_days')->default(0);
            $table->date('started_at')->nullable();
            $table->date('completed_at')->nullable();
            $table->integer('status')->default(0);
            $table->json('day_completions')->nullable();
            $table->integer('total_calories_burned')->default(0);
            $table->integer('total_duration')->default(0);
            $table->integer('streak')->default(0);
            $table->float('rating')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'challenge_id'], 'ucp_unique');
            $table->index(['user_id', 'status'], 'ucp_user_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_challenge_progress');
    }
};