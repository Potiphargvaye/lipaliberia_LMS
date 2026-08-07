<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {

            $table->id();

            // Basic Information
            $table->string('title');
            $table->string('slug')->unique();

            // Classification
            $table->string('category')->nullable();
            $table->string('group')->nullable();
            $table->string('group_label')->nullable();
            $table->string('programme_type')->nullable();

            // Course Details
            $table->text('overview')->nullable();
            $table->text('target_audience')->nullable();
            $table->text('entry_requirements')->nullable();

            // Logistics
            $table->string('duration')->nullable();
            $table->string('schedule')->nullable();
            $table->decimal('fee', 10, 2)->nullable();
            $table->unsignedInteger('seats')->nullable();

            // Media
            $table->string('image')->nullable();

            // Publication
            $table->boolean('is_active')->default(true);

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
