<?php

namespace App\Livewire\Admin\Assignments;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\Enrollment;
use Livewire\Component;
use Livewire\WithPagination;

class Submissions extends Component
{
    use WithPagination;

    public Assignment $assignment;

    public $search = '';
    public $statusFilter = ''; // submitted / not_submitted / graded / ungraded

    public bool $showReviewModal = false;
    public $viewingSubmission = null;

    public $grade = '';
    public $feedback = '';

    public function mount(Assignment $assignment)
    {
        $assignment->loadMissing('module.course');

        abort_unless(
            Course::visibleTo(auth()->user())->where('id', $assignment->module->course_id)->exists(),
            403
        );

        $this->assignment = $assignment;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function openReview(int $submissionId)
    {
        if (!auth()->user()->can('manage assignments')) {
            abort(403);
        }

        $submission = AssignmentSubmission::with('student')
            ->where('assignment_id', $this->assignment->id)
            ->findOrFail($submissionId);

        $this->viewingSubmission = $submission;
        $this->grade = $submission->grade ?? '';
        $this->feedback = $submission->feedback ?? '';

        $this->showReviewModal = true;
    }

    public function saveGrade()
    {
        if (!auth()->user()->can('manage assignments')) {
            abort(403);
        }

        $this->validate([
            'grade' => 'nullable|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $this->viewingSubmission->update([
            'grade' => $this->grade !== '' ? $this->grade : null,
            'feedback' => $this->feedback,
            'graded_by' => auth()->id(),
            'graded_at' => now(),
        ]);

        $this->showReviewModal = false;

        $this->dispatch('notify', message: 'Submission graded.', type: 'success');
    }

    public function closeReview()
    {
        $this->showReviewModal = false;
        $this->viewingSubmission = null;

        $this->grade = '';
        $this->feedback = '';

        $this->resetErrorBag();
    }

    public function render()
    {
        $assignmentId = $this->assignment->id;
        $courseId = $this->assignment->module->course_id;

        $enrollments = Enrollment::query()
            ->where('course_id', $courseId)
            ->whereIn('status', ['enrolled', 'in_training', 'completed', 'suspended'])
            ->with(['student.user'])
            ->when($this->search, function ($query) {
                $query->whereHas(
                    'student.user',
                    fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
                );
            })
            ->when($this->statusFilter === 'submitted', function ($query) use ($assignmentId) {
                $query->whereHas(
                    'student.user.assignmentSubmissions',
                    fn($q) => $q->where('assignment_id', $assignmentId)
                );
            })
            ->when($this->statusFilter === 'not_submitted', function ($query) use ($assignmentId) {
                $query->whereDoesntHave(
                    'student.user.assignmentSubmissions',
                    fn($q) => $q->where('assignment_id', $assignmentId)
                );
            })
            ->when($this->statusFilter === 'graded', function ($query) use ($assignmentId) {
                $query->whereHas(
                    'student.user.assignmentSubmissions',
                    fn($q) => $q->where('assignment_id', $assignmentId)->whereNotNull('grade')
                );
            })
            ->when($this->statusFilter === 'ungraded', function ($query) use ($assignmentId) {
                $query->whereHas(
                    'student.user.assignmentSubmissions',
                    fn($q) => $q->where('assignment_id', $assignmentId)->whereNull('grade')
                );
            })
            ->orderBy('created_at')
            ->paginate(15);

        // Attach each enrolled student's submission (if any) for this
        // assignment, without an N+1 query per row.
        $userIds = $enrollments->getCollection()
            ->pluck('student.user.id')
            ->filter()
            ->values();

        $submissionsByUser = AssignmentSubmission::where('assignment_id', $assignmentId)
            ->whereIn('student_id', $userIds)
            ->get()
            ->keyBy('student_id');

        $enrollments->getCollection()->transform(function ($enrollment) use ($submissionsByUser) {
            $userId = $enrollment->student->user->id ?? null;
            $enrollment->submission = $userId ? ($submissionsByUser->get($userId)) : null;
            return $enrollment;
        });

        return view('livewire.admin.assignments.submissions', [
            'enrollments' => $enrollments,
        ]);
    }
}
