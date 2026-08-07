<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'group',
        'group_label',
        'programme_type',
        'overview',
        'target_audience',
        'entry_requirements',
        'duration',
        'schedule',
        'fee',
        'seats',
        'image',
        'is_active',
    ];


    protected $casts = [
        'fee' => 'decimal:2',
        'is_active' => 'boolean',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }


    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if this course can be deleted.
     */
    public function canBeDeleted(): bool
    {
        return ! $this->applications()->exists()
            && ! $this->enrollments()->exists();
    }
}
