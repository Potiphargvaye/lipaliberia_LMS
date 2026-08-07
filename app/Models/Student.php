<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'date_of_birth',
        'nationality',
        'county_of_residence',
        'home_address',
        'mobile_number',
        'whatsapp_number',
        'employment_status',
        'employer_name',
        'position_title',
        'institution_contact_detail',
        'institution_contact_info',
        'years_experience',
        'highest_qualification',
        'institution_attended',
        'field_of_study',
        'year_completed',
        'passport_photo_path',
        'academic_certificate_path',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'requires_special_accommodation',
        'special_accommodation_details',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'requires_special_accommodation' => 'boolean',
        'years_experience' => 'integer',
        'year_completed' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * The login account this Student profile belongs to.
     * The Student ID shown in the UI is $student->user->registration_id —
     * there is no separate student_id column on this table.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Every Application this student has ever submitted, across all
     * courses/ cohort over time.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Every Enrollment this student has ever had (one per approved
     * Application).
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }




    /**
     * Every Fee Assignment across all of this student's enrollments.
     * Chained through Enrollment since fee_assignments now belongs to
     * enrollment_id, not student_id directly.
     */
    public function feeAssignments(): HasManyThrough
    {
        return $this->hasManyThrough(FeeAssignment::class, Enrollment::class);
    }
    /*
    |--------------------------------------------------------------------------
    | Convenience accessors
    |--------------------------------------------------------------------------
    */

    /**
     * The most recent Application, used to drive the student dashboard's
     * status card (pending / approved / etc).
     */
    public function latestApplication()
    {
        return $this->applications()->latest()->first();
    }

    /**
     * The most recent active Enrollment (if any), used to drive the
     * dashboard's "continue training" / certificate card.
     */
    public function activeEnrollment()
    {
        return $this->enrollments()
            ->whereIn('status', ['enrolled', 'in_training'])
            ->latest()
            ->first();
    }
}
