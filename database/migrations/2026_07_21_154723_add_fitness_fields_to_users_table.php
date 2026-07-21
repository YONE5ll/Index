<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('body_fat', 8, 2)->nullable();
            $table->string('fitness_goal')->nullable();
            $table->string('activity_level')->nullable();
            $table->text('medical_notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['weight', 'height', 'body_fat', 'fitness_goal', 'activity_level', 'medical_notes']);
        });
    }
};