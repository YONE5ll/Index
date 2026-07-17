<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id(); // Exercise ID
            $table->string('name');            // Exercise Name
            $table->string('muscle_group');    // Category e.g. Chest, Back, Legs
            $table->text('description');       // Short Description
            $table->string('image_path');      // Placeholder image path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};