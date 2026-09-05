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
        Schema::create('live_classes', function (Blueprint $table) {
            $table->id();

            // Ownership / scope-relevant relationships.
            // Visibility is derived from course_id via Course::visibleTo() —
            // never from created_by or facilitator_id.
            $table->foreignId('course_id')
                ->constrained('courses')
                ->cascadeOnDelete();

            $table->foreignId('module_id')
                ->nullable()
                ->constrained('modules')
                ->nullOnDelete();

            $table->foreignId('cohort_id')
                ->nullable()
                ->constrained('cohorts')
                ->nullOnDelete();

            // The facilitator leading this specific session. This is
            // informational only — it does NOT gate visibility. Any
            // facilitator assigned to the course can see/manage this row.
            $table->foreignId('facilitator_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Session details
            $table->string('title');
            $table->text('description')->nullable();

            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');

            $table->enum('platform', ['google_meet', 'zoom', 'teams', 'other']);
            $table->string('meeting_url');

            $table->enum('status', ['scheduled', 'live', 'completed', 'cancelled'])
                ->default('scheduled');

            // Audit trail only — never used for authorization/visibility.
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['course_id', 'date']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_classes');
    }
};
