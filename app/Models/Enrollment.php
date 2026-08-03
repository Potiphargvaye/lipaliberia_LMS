<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'application_id',
        'student_id',
        'course_id',
        'intake_id',
        'status',
        'progress_percentage',
        'certificate_issued',
        'certificate_path',
        'completed_at',
        'withdrawn_at',
        'withdrawal_reason',
    ];


    protected $casts = [
        'certificate_issued' => 'boolean',
        'completed_at' => 'datetime',
        'withdrawn_at' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    public function application()
    {
        return $this->belongsTo(Application::class);
    }


    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function intake()
    {
        return $this->belongsTo(Intake::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Enrollment Lifecycle
    |--------------------------------------------------------------------------
    */


    public function markInTraining()
    {
        $this->update([
            'status' => 'in_training'
        ]);
    }


    public function complete()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
    }


    public function withdraw($reason)
    {
        $this->update([
            'status' => 'withdrawn',
            'withdrawn_at' => now(),
            'withdrawal_reason' => $reason
        ]);
    }


    public function suspend()
    {
        $this->update([
            'status' => 'suspended'
        ]);
    }



    /**
     * Bring a suspended Enrollment back to an active state. There's no
     * stored "previous status" column, so the admin picks which active
     * state to resume into (enrolled or in_training) via the UI.
     */
    public function reactivate(string $toStatus)
    {
        if (! in_array($toStatus, ['enrolled', 'in_training'])) {
            throw new \InvalidArgumentException('Can only reactivate into enrolled or in_training.');
        }

        $this->update([
            'status' => $toStatus,
        ]);
    }

    /**
     * Update training progress. Kept as its own method (rather than a bare
     * ->update() call in the Livewire component) so any future validation
     * of allowed progress values has one place to live.
     */
    public function updateProgress(int $percentage)
    {
        $this->update([
            'progress_percentage' => max(0, min(100, $percentage)),
        ]);
    }

    /**
     * Issue a certificate. Business Rule #6: only allowed once the
     * Enrollment is completed.
     */
    public function issueCertificate(string $path)
    {
        if ($this->status !== 'completed') {
            throw new \RuntimeException('Certificates can only be issued for completed enrollments.');
        }

        $this->update([
            'certificate_issued' => true,
            'certificate_path' => $path,
        ]);
    }
}
