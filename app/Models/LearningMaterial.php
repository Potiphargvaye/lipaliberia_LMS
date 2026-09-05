<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearningMaterial extends Model
{
    use HasFactory;

    /**
     * Material types and their display labels — single source of truth
     * for validation, form rendering, and preview logic.
     */
    public const TYPE_LABELS = [
        'video' => 'Video',
        'pdf' => 'PDF Document',
        'powerpoint' => 'PowerPoint Presentation',
        'word' => 'Word Document',
        'text' => 'Text Content',
        'external_link' => 'External Link',
        'downloadable' => 'Downloadable Resource / ZIP',
    ];

    /**
     * Types that require a file upload.
     */
    public const FILE_TYPES = ['video', 'pdf', 'powerpoint', 'word', 'downloadable'];

    /**
     * Per-type file validation rules (extensions + max size in KB).
     */
    public const FILE_RULES = [
        'video' => 'mimes:mp4,mov,webm|max:102400',       // 100MB
        'pdf' => 'mimes:pdf|max:20480',                    // 20MB
        'powerpoint' => 'mimes:ppt,pptx|max:30720',        // 30MB
        'word' => 'mimes:doc,docx|max:15360',              // 15MB
        'downloadable' => 'mimes:zip,rar|max:51200',       // 50MB
    ];

    protected $fillable = [
        'module_id',
        'title',
        'type',
        'file_path',
        'external_url',
        'content',
        'description',
        'material_order',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'material_order' => 'integer',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
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

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isFileType(): bool
    {
        return in_array($this->type, self::FILE_TYPES, true);
    }

    public function typeLabel(): string
    {
        return self::TYPE_LABELS[$this->type] ?? $this->type;
    }

    /**
     * Check if this material can be deleted.
     * Materials are currently leaf nodes — always deletable.
     */
    public function canBeDeleted(): bool
    {
        return true;
    }
}
