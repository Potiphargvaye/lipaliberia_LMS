<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\CourseCategory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'course_category_id',
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

    public function courseCategory(): BelongsTo
    {
        return $this->belongsTo(
            CourseCategory::class,
            'course_category_id',
            'id'
        );
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    public function facilitators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_facilitators')->withTimestamps();
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
     * Restrict a course query to what $user is allowed to see.
     * Users with 'view all course records' (Super Admin, Administrator)
     * see everything, unchanged from current behavior. Everyone else —
     * primarily Facilitator — only sees courses they're assigned to.
     */
    public function scopeVisibleTo($query, User $user)
    {
        if ($user->can('view all course records')) {
            return $query;
        }

        return $query->whereHas('facilitators', fn($q) => $q->where('user_id', $user->id));
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
