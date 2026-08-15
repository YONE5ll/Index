<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->string('difficulty');
            $table->integer('duration'); // in minutes
            $table->integer('calories_burned');
            $table->json('target_muscles');
            $table->json('equipment')->nullable();
            $table->json('instructions')->nullable();
            $table->string('image_url')->nullable();
            $table->string('video_url')->nullable();
            $table->integer('level')->default(1);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};