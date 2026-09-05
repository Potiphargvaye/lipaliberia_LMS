<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use Illuminate\View\View;

class StudentLiveClassController extends Controller
{
    /**
     * Enrollment statuses that entitle a student to see live classes for
     * that course. 'withdrawn' and 'suspended' do not — a student who has
     * left or been suspended from a course loses visibility into its
     * live sessions.
     */
    private const VISIBLE_ENROLLMENT_STATUSES = ['enrolled', 'in_training', 'completed'];

    public function index(): View
    {
        $student = auth()->user()->student;

        // A user with no Student profile (staff/admin account) has nothing
        // to be enrolled in, so nothing to see here.
        abort_unless($student, 403);

        $enrollments = $student->enrollments()
            ->whereIn('status', self::VISIBLE_ENROLLMENT_STATUSES)
            ->get(['course_id', 'cohort_id']);

        $liveClasses = collect();

        if ($enrollments->isNotEmpty()) {
            $liveClasses = LiveClass::query()
                ->with(['course', 'module', 'cohort', 'facilitator'])
                ->where(function ($query) use ($enrollments) {
                    foreach ($enrollments as $enrollment) {
                        $query->orWhere(function ($q) use ($enrollment) {
                            $q->where('course_id', $enrollment->course_id)
                                ->where(function ($q2) use ($enrollment) {
                                    // No cohort on the live class = visible to
                                    // every enrolled student in the course.
                                    // A cohort-scoped live class is only
                                    // visible if this enrollment is in that
                                    // exact course + cohort combination.
                                    // created_by / facilitator_id are never
                                    // consulted here — only course + cohort,
                                    // matching the admin-side visibleTo() rule.
                                    $q2->whereNull('cohort_id')
                                        ->orWhere('cohort_id', $enrollment->cohort_id);
                                });
                        });
                    }
                })
                ->orderBy('date')
                ->orderBy('start_time')
                ->get();
        }

        return view('student.live-classes.index', [
            'liveNow' => $liveClasses->where('status', 'live')->values(),
            'upcoming' => $liveClasses->where('status', 'scheduled')->values(),
            'past' => $liveClasses
                ->whereIn('status', ['completed', 'cancelled'])
                ->sortByDesc(fn($lc) => $lc->date->toDateString() . ' ' . $lc->start_time)
                ->values(),
        ]);
    }
}
