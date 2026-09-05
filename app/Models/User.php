<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\SchoolResetPasswordNotification;

use App\Models\Student;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Guard name for Spatie Permission.
     */
    protected $guard_name = 'web';


    /**
     * Mass assignable attributes.
     */
    protected $fillable = [

        // Login Information
        'registration_id',

        'name',

        'email',

        'image',

        // Authentication
        'password',

        // Account Status
        'status',

        // Login Tracking
        'last_login_at',
        'created_by',

    ];


    /**
     * Hidden attributes.
     */
    protected $hidden = [

        'password',

        'remember_token',

    ];


    /**
     * Attribute casting.
     */
    protected $casts = [

        'email_verified_at' => 'datetime',

        'last_login_at' => 'datetime',

        'password' => 'hashed',

    ];


    /**
     * Send password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(
            new SchoolResetPasswordNotification($token)
        );
    }


    /**
     * User who created this account.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Users created by this account.
     */
    public function createdUsers()
    {
        return $this->hasMany(User::class, 'created_by');
    }


    public function createdModules(): HasMany
    {
        return $this->hasMany(Module::class, 'created_by');
    }


    public function facilitatedCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_facilitators')->withTimestamps();
    }
    /**
     * The Student profile linked to this account, if this user is a student.
     * Staff/admin users will simply have this return null.
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function assignmentSubmissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class, 'student_id');
    }

    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class, 'student_id');
    }
}
