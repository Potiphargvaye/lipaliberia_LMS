<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    use HasFactory;

    public const CONTENT_TYPES = [
        'text' => 'Text Instructions',
        'file' => 'Uploaded Document (PDF / Word / PPT)',
    ];

    protected $fillable = [
        'module_id',
        'title',
        'instructions',
        'content_type',
        'content_text',
        'content_file_path',
        'due_date',
        'is_required',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function isPastDue(): bool
    {
        return $this->due_date && now()->greaterThan($this->due_date);
    }
}
