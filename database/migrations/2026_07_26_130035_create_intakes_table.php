<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Intakes are kept independent of a single course (e.g. "January 2026
     * Intake" can apply across several courses) — Applications reference
     * both course_id and intake_id independently.
     */
    public function up(): void
    {
        Schema::create('intakes', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->date('start_date');

            $table->date('end_date')->nullable();

            $table->date('application_deadline')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intakes');
    }
};
