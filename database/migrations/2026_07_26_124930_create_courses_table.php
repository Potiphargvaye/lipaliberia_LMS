<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This is a minimal stub — extended later by the full Course Management
     * module (categories/instructors will likely become their own related
     * tables at that point; kept as plain strings here to unblock the
     * Student Module now).
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->text('description')->nullable();

            $table->string('thumbnail')->nullable();

            $table->string('category')->nullable();

            $table->string('instructor')->nullable();

            $table->string('duration')->nullable();

            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->nullable();

            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
