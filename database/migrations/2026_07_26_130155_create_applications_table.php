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
        Schema::create('applications', function (Blueprint $table) {

            $table->id();

            $table->string('application_number')->unique();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->foreignId('course_id')
                ->constrained('courses')
                ->restrictOnDelete();

            $table->foreignId('intake_id')
                ->constrained('intakes')
                ->restrictOnDelete();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'cancelled',
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Section E - Course / How Heard
            |--------------------------------------------------------------------------
            */

            $table->string('how_heard_about_us')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Section E - Payment / Sponsorship
            |--------------------------------------------------------------------------
            */

            $table->enum('sponsorship_type', ['self', 'employer', 'other'])->nullable();

            $table->string('sponsor_organization_name')->nullable();

            $table->boolean('requires_invoice')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Section H - Training Needs Assessment
            |--------------------------------------------------------------------------
            */

            $table->text('interest_reason')->nullable();

            $table->text('skills_hoped_to_gain')->nullable();

            $table->boolean('previously_attended_lipa_training')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Review
            |--------------------------------------------------------------------------
            */

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();

            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
