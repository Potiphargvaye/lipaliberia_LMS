<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_number',
        'student_id',
        'course_id',
        'intake_id',
        'status',
        'how_heard_about_us',
        'sponsorship_type',
        'sponsor_organization_name',
        'requires_invoice',
        'interest_reason',
        'skills_hoped_to_gain',
        'previously_attended_lipa_training',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
    ];

    protected $casts = [
        'requires_invoice' => 'boolean',
        'previously_attended_lipa_training' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function intake(): BelongsTo
    {
        return $this->belongsTo(Intake::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * An Application produces at most one Enrollment (only once approved).
     */
    public function enrollment(): HasOne
    {
        return $this->hasOne(Enrollment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Business logic
    |--------------------------------------------------------------------------
    | Kept here (rather than duplicated inside Livewire components) so the
    | Admin Applications module and any future API/console command call the
    | exact same approve/reject logic.
    */

    /**
     * Approve this Application and create its Enrollment.
     * This is the single trigger point for Enrollment creation —
     * per the architecture's Business Rule #5.
     */
    public function approve(User $reviewer): Enrollment
    {
        $this->update([
            'status' => 'approved',
            'reviewed_by' => $reviewer->id,
            'reviewed_at' => now(),
        ]);

        return $this->enrollment()->create([
            'student_id' => $this->student_id,
            'course_id' => $this->course_id,
            'intake_id' => $this->intake_id,
            'status' => 'enrolled',
        ]);
    }

    /**
     * Reject this Application. A reason is required per validation rules.
     */
    public function reject(User $reviewer, string $reason): void
    {
        $this->update([
            'status' => 'rejected',
            'reviewed_by' => $reviewer->id,
            'reviewed_at' => now(),
            'rejection_reason' => $reason,
        ]);
    }



    /**
     * Generate the next unique Application Number.
     *
     * Format: APP/{year}/{5-digit sequence} — e.g. APP/2026/00123
     *
     * Same single-source-of-truth principle as RegistrationIdService: both
     * Admin Registration and (later) Public Registration call this instead
     * of duplicating a numbering loop.
     */
    public static function generateApplicationNumber(): string
    {
        $year = now()->year;

        $lastApplication = static::where('application_number', 'like', "APP/{$year}/%")
            ->orderByDesc('id')
            ->first();

        $nextNumber = 1;

        if (
            $lastApplication &&
            preg_match('/(\d+)$/', $lastApplication->application_number, $matches)
        ) {
            $nextNumber = (int) $matches[1] + 1;
        }

        do {
            $applicationNumber =
                'APP/' .
                $year .
                '/' .
                str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $nextNumber++;
        } while (
            static::where('application_number', $applicationNumber)->exists()
        );

        return $applicationNumber;
    }
}
