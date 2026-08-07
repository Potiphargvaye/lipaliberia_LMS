<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * An Enrollment only ever exists because an Application was approved —
     * application_id is unique so there can never be more than one
     * Enrollment per Application. student_id/course_id/cohort_id are
     * denormalized copies from the source Application, kept in sync at
     * creation time, so the admin table and student dashboard can query
     * this table directly without deep joins.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {

            $table->id();


            $table->foreignId('application_id')
                ->unique()
                ->constrained('applications')
                ->cascadeOnDelete();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('course_id')
                ->constrained('courses')
                ->restrictOnDelete();

            $table->foreignId('cohort_id')
                ->constrained('cohorts')
                ->restrictOnDelete();

            $table->enum('status', [
                'enrolled',
                'in_training',
                'completed',
                'withdrawn',
                'suspended',
            ])->default('enrolled');

            $table->unsignedTinyInteger('progress_percentage')->nullable();

            $table->boolean('certificate_issued')->default(false);

            $table->string('certificate_path')->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->timestamp('withdrawn_at')->nullable();

            $table->text('withdrawal_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
