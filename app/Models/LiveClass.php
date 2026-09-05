<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'module_id',
        'cohort_id',
        'facilitator_id',
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'platform',
        'meeting_url',
        'status',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function cohort(): BelongsTo
    {
        return $this->belongsTo(Cohort::class);
    }

    /**
     * The facilitator leading this specific session.
     * Informational / display purposes only — NOT used for visibility.
     */
    public function facilitator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'facilitator_id');
    }

    /**
     * Who created the record. Audit trail only — NOT used for visibility.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Restrict a live class query to what $user is allowed to see.
     * Mirrors Course::scopeVisibleTo() exactly, by delegating to it —
     * a Live Class is visible if its Course is visible. This deliberately
     * avoids a second, independent authorization mechanism.
     *
     * created_by and facilitator_id are never consulted here.
     */
    public function scopeVisibleTo($query, User $user)
    {
        return $query->whereHas('course', fn($q) => $q->visibleTo($user));
    }
}
