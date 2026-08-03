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
        Schema::create('students', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Link to Account (required — Student and User are created together)
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Section A - Personal Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->enum('gender', ['male', 'female', 'other']);

            $table->date('date_of_birth');

            $table->string('nationality');

            $table->string('county_of_residence');

            $table->text('home_address');

            $table->string('mobile_number');

            $table->string('whatsapp_number')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Section B - Employment
            |--------------------------------------------------------------------------
            */

            $table->enum('employment_status', [
                'employed',
                'self_employed',
                'unemployed',
                'student',
                'other',
            ]);

            $table->string('employer_name')->nullable();

            $table->string('position_title')->nullable();

            $table->string('institution_contact_detail')->nullable();

            $table->text('institution_contact_info')->nullable();

            $table->unsignedInteger('years_experience')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Section C - Education
            |--------------------------------------------------------------------------
            */

            $table->enum('highest_qualification', [
                'certificate',
                'diploma',
                'bachelor',
                'master',
                'doctorate',
                'other',
            ]);

            $table->string('institution_attended')->nullable();

            $table->string('field_of_study')->nullable();

            $table->unsignedSmallInteger('year_completed')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Section D - Uploads
            |--------------------------------------------------------------------------
            */

            $table->string('passport_photo_path')->nullable();

            $table->string('academic_certificate_path')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Section F - Emergency Contact
            |--------------------------------------------------------------------------
            */

            $table->string('emergency_contact_name');

            $table->string('emergency_contact_phone');

            $table->string('emergency_contact_relationship');

            $table->boolean('requires_special_accommodation')->default(false);

            $table->text('special_accommodation_details')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
