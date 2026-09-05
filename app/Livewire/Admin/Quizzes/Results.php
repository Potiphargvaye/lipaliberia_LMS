<?php

namespace App\Livewire\Admin\Quizzes;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Livewire\Component;
use Livewire\WithPagination;

class Results extends Component
{
    use WithPagination;

    public Quiz $quiz;

    public $search = '';
    public $statusFilter = ''; // attempted / not_attempted / passed / failed

    public bool $showModal = false;

    // Level 1: list of a student's attempts for this quiz
    public $viewingStudentName = null;
    public $viewingStudentAttempts = null;

    // Level 2: a single attempt's answer detail (drilled into from level 1)
    public $viewingAttempt = null;

    public function mount(Quiz $quiz)
    {
        $quiz->loadMissing('module.course');

        // Defense in depth: same scope check as the controller, kept
        // here too in case this component is ever reused elsewhere.
        abort_unless(
            Course::visibleTo(auth()->user())->where('id', $quiz->module->course_id)->exists(),
            403
        );

        $this->quiz = $quiz;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    /**
     * Level 1: open the modal showing every attempt a student has made
     * on this quiz.
     */
    public function viewStudentAttempts(int $userId, string $studentName)
    {
        $this->viewingStudentName = $studentName;

        $this->viewingStudentAttempts = QuizAttempt::where('quiz_id', $this->quiz->id)
            ->where('student_id', $userId)
            ->orderByDesc('attempt_number')
            ->get();

        $this->viewingAttempt = null;

        $this->showModal = true;
    }

    /**
     * Level 2: drill into one specific attempt's answers.
     */
    public function viewAttemptDetail(int $attemptId)
    {
        $this->viewingAttempt = QuizAttempt::with(['student', 'answers.question.options', 'answers.selectedOptions'])
            ->where('quiz_id', $this->quiz->id)
            ->findOrFail($attemptId);
    }

    /**
     * Back out of the answer-detail view to the attempt list.
     */
    public function backToAttemptList()
    {
        $this->viewingAttempt = null;
    }

    public function closeModal()
    {
        $this->showModal = false;

        $this->viewingStudentName = null;
        $this->viewingStudentAttempts = null;
        $this->viewingAttempt = null;
    }

    public function render()
    {
        $quizId = $this->quiz->id;
        $courseId = $this->quiz->module->course_id;

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
            ->when($this->statusFilter === 'attempted', function ($query) use ($quizId) {
                $query->whereHas(
                    'student.user.quizAttempts',
                    fn($q) => $q->where('quiz_id', $quizId)
                );
            })
            ->when($this->statusFilter === 'not_attempted', function ($query) use ($quizId) {
                $query->whereDoesntHave(
                    'student.user.quizAttempts',
                    fn($q) => $q->where('quiz_id', $quizId)
                );
            })
            ->when($this->statusFilter === 'passed', function ($query) use ($quizId) {
                $query->whereHas(
                    'student.user.quizAttempts',
                    fn($q) => $q->where('quiz_id', $quizId)->where('passed', true)
                );
            })
            ->when($this->statusFilter === 'failed', function ($query) use ($quizId) {
                $query
                    ->whereHas(
                        'student.user.quizAttempts',
                        fn($q) => $q->where('quiz_id', $quizId)
                    )
                    ->whereDoesntHave(
                        'student.user.quizAttempts',
                        fn($q) => $q->where('quiz_id', $quizId)->where('passed', true)
                    );
            })
            ->orderBy('created_at')
            ->paginate(15);

        // Attach each enrolled student's attempts for this quiz, keyed by
        // user id, without an N+1 query per row.
        $userIds = $enrollments->getCollection()
            ->pluck('student.user.id')
            ->filter()
            ->values();

        $attemptsByUser = QuizAttempt::where('quiz_id', $quizId)
            ->whereIn('student_id', $userIds)
            ->get()
            ->groupBy('student_id');

        $enrollments->getCollection()->transform(function ($enrollment) use ($attemptsByUser) {
            $userId = $enrollment->student->user->id ?? null;

            $attempts = $userId ? $attemptsByUser->get($userId, collect()) : collect();

            $enrollment->attemptsCount = $attempts->count();
            $enrollment->bestAttempt = $attempts->sortByDesc('score')->first();
            $enrollment->lastAttempt = $attempts->sortByDesc('attempt_number')->first();

            return $enrollment;
        });

        return view('livewire.admin.quizzes.results', [
            'enrollments' => $enrollments,
        ]);
    }
}
