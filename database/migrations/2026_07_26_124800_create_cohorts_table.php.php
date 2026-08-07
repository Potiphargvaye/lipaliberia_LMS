<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cohorts', function (Blueprint $table) {

            $table->id();

            // Example: Cohort 1 - 2026
            $table->string('name')->unique();

            // Example: C1-2026
            $table->string('code')->unique();

            // Cohort schedule
            $table->date('start_date');

            $table->date('end_date')->nullable();

            // Admission deadline
            $table->date('application_deadline')->nullable();

            // Display order
            $table->integer('sort_order')->default(0);

            // Current active cohort
            $table->boolean('is_active')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cohorts');
    }
};
