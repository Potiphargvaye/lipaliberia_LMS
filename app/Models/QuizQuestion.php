<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizQuestion extends Model
{
    use HasFactory;

    public const TYPES = [
        'mcq' => 'Multiple Choice (single answer)',
        'checkbox' => 'Multiple Choice (multiple answers)',
        'true_false' => 'True / False',
    ];

    protected $fillable = [
        'quiz_id',
        'question_text',
        'type',
        'points',
        'question_order',
    ];

    protected $casts = [
        'points' => 'integer',
        'question_order' => 'integer',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuizOption::class)->orderBy('option_order');
    }

    public function isMultiSelect(): bool
    {
        return $this->type === 'checkbox';
    }
}
