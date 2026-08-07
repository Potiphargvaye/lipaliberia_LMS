<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    /**
     * Student Dashboard
     *
     * Pulls everything from the Student -> Applications -> Enrollments
     * relationships already defined on the Student model. No new
     * business logic is introduced here — status transitions, progress,
     * and certificate rules all continue to live on Application and
     * Enrollment as before.
     */
    public function index(): View
    {
        $student = Student::with('user')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $applications = $student->applications()
            ->with(['course', 'cohort'])
            ->latest()
            ->get();

        $enrollments = $student->enrollments()
            ->with(['course', 'cohort'])
            ->latest()
            ->get();

        // Reuse the existing accessors on Student rather than re-deriving
        // this logic here.
        $latestApplication = $student->latestApplication();
        $activeEnrollment = $student->activeEnrollment();

        $completedEnrollment = $enrollments->firstWhere('status', 'completed');

        $latestCertificate = $enrollments->first(
            fn($enrollment) => $enrollment->certificate_issued && $enrollment->certificate_path
        );

        $stats = [
            'applications' => $applications->count(),
            'active_enrollments' => $enrollments->whereIn('status', ['enrolled', 'in_training'])->count(),
            'completed_courses' => $enrollments->where('status', 'completed')->count(),
            'certificates' => $enrollments->where('certificate_issued', true)->count(),
        ];

        // Recent Activity — built purely from timestamps already on
        // Application/Enrollment (created_at, reviewed_at, completed_at,
        // withdrawn_at). No new activity_log table yet, per the
        // architecture doc's "Future Scalability" note.
        $activity = collect();

        foreach ($applications as $application) {
            $activity->push([
                'icon' => 'bi-file-earmark-plus',
                'variant' => 'info',
                'title' => 'Application submitted',
                'description' => $application->course->title ?? 'Course',
                'date' => $application->created_at,
            ]);

            if ($application->reviewed_at) {
                $activity->push([
                    'icon' => $application->status === 'approved' ? 'bi-check-circle' : 'bi-x-circle',
                    'variant' => $application->status === 'approved' ? 'success' : 'danger',
                    'title' => 'Application ' . ucfirst($application->status),
                    'description' => $application->course->title ?? 'Course',
                    'date' => $application->reviewed_at,
                ]);
            }
        }

        foreach ($enrollments as $enrollment) {
            $activity->push([
                'icon' => 'bi-mortarboard',
                'variant' => 'primary',
                'title' => 'Enrolled in course',
                'description' => $enrollment->course->title ?? 'Course',
                'date' => $enrollment->created_at,
            ]);

            if ($enrollment->completed_at) {
                $activity->push([
                    'icon' => 'bi-award',
                    'variant' => 'success',
                    'title' => 'Course completed',
                    'description' => $enrollment->course->title ?? 'Course',
                    'date' => $enrollment->completed_at,
                ]);
            }

            if ($enrollment->withdrawn_at) {
                $activity->push([
                    'icon' => 'bi-dash-circle',
                    'variant' => 'warning',
                    'title' => 'Enrollment withdrawn',
                    'description' => $enrollment->course->title ?? 'Course',
                    'date' => $enrollment->withdrawn_at,
                ]);
            }
        }

        $activity = $activity->sortByDesc('date')->take(6)->values();

        return view('student.dashboard', compact(
            'student',
            'applications',
            'enrollments',
            'latestApplication',
            'activeEnrollment',
            'completedEnrollment',
            'latestCertificate',
            'stats',
            'activity'
        ));
    }
}
