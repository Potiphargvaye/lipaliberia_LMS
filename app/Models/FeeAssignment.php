<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeAssignment extends Model
{
    protected $fillable = [
        'enrollment_id',
        'fee_category_id',
        'installment_number',
        'amount',
        'due_date',
        'remarks',
        'status',
        'assigned_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    
    public function feeCategory(): BelongsTo
    {
        return $this->belongsTo(FeeCategory::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(FeePayment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic
    |--------------------------------------------------------------------------
    */

    public function totalPaid(): string
    {
        return (string) $this->payments()->sum('amount_paid');
    }

    public function balance(): string
    {
        return bcsub((string) $this->amount, $this->totalPaid(), 2);
    }

    public function recalculateStatus(): void
    {
        $totalPaid = (float) $this->totalPaid();
        $amount = (float) $this->amount;

        if ($totalPaid <= 0) {
            $status = $this->due_date && $this->due_date->isPast()
                ? 'overdue'
                : 'pending';
        } elseif ($totalPaid >= $amount) {
            $status = 'paid';
        } else {
            $status = $this->due_date && $this->due_date->isPast()
                ? 'overdue'
                : 'partial';
        }

        $this->update([
            'status' => $status,
        ]);
    }

    public function canBeDeleted(): bool
    {
        return $this->payments()->doesntExist();
    }

    public function isLockedForEditing(): bool
    {
        return $this->payments()->exists();
    }
}
