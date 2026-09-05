<?php

namespace App\Livewire\Admin\Quizzes;

use App\Models\Course;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizOption;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public bool $showModal = false;

    public $editingId = null;

    public $courseId = '';
    public $moduleId = '';
    public $title = '';
    public $description = '';
    public $passingScore = 70;
    public $maxAttempts = 3;
    public $timeLimitMinutes = '';
    public bool $isRequired = true;
    public bool $isActive = true;

    /**
     * questions: [
     *   ['question_text' => '', 'type' => 'mcq', 'points' => 1,
     *    'options' => [['option_text' => '', 'is_correct' => false], ...]],
     *   ...
     * ]
     */
    public $questions = [];

    public bool $lockedByAttempts = false;

    public $deleteId = null;
    public $deleteQuizName = '';
    public bool $showDeleteModal = false;

    public $search = '';
    public $courseFilter = '';

    /*
    |--------------------------------------------------------------------------
    | Search / Filter
    |--------------------------------------------------------------------------
    */

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedCourseFilter()
    {
        $this->resetPage();
    }

    public function updatedCourseId()
    {
        $this->moduleId = '';
    }

    /*
    |--------------------------------------------------------------------------
    | Question / Option builder helpers
    |--------------------------------------------------------------------------
    */

    public function addQuestion()
    {
        $this->questions[] = [
            'question_text' => '',
            'type' => 'mcq',
            'points' => 1,
            'options' => [
                ['option_text' => '', 'is_correct' => false],
                ['option_text' => '', 'is_correct' => false],
            ],
        ];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function addOption($qIndex)
    {
        $this->questions[$qIndex]['options'][] = ['option_text' => '', 'is_correct' => false];
    }

    public function removeOption($qIndex, $oIndex)
    {
        unset($this->questions[$qIndex]['options'][$oIndex]);
        $this->questions[$qIndex]['options'] = array_values($this->questions[$qIndex]['options']);
    }

    public function changeQuestionType($qIndex)
    {
        $type = $this->questions[$qIndex]['type'];

        if ($type === 'true_false') {
            $this->questions[$qIndex]['options'] = [
                ['option_text' => 'True', 'is_correct' => true],
                ['option_text' => 'False', 'is_correct' => false],
            ];
        }
    }

    /**
     * Enforces single-correct-answer for mcq/true_false when a checkbox
     * is toggled on — unchecks any previously selected option.
     */
    public function markCorrect($qIndex, $oIndex)
    {
        $type = $this->questions[$qIndex]['type'];

        if ($type !== 'checkbox') {
            foreach ($this->questions[$qIndex]['options'] as $i => $option) {
                $this->questions[$qIndex]['options'][$i]['is_correct'] = ($i === $oIndex);
            }
        } else {
            $current = $this->questions[$qIndex]['options'][$oIndex]['is_correct'];
            $this->questions[$qIndex]['options'][$oIndex]['is_correct'] = !$current;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function openCreateModal()
    {
        if (!auth()->user()->can('manage quizzes')) {
            abort(403);
        }

        $this->reset([
            'editingId',
            'courseId',
            'moduleId',
            'title',
            'description',
            'timeLimitMinutes',
        ]);

        $this->passingScore = 70;
        $this->maxAttempts = 3;
        $this->isRequired = true;
        $this->isActive = true;
        $this->lockedByAttempts = false;

        $this->questions = [];
        $this->addQuestion();

        $this->showModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function openEditModal(int $id)
    {
        if (!auth()->user()->can('manage quizzes')) {
            abort(403);
        }

        $quiz = Quiz::with('questions.options', 'module')->findOrFail($id);

        $this->editingId = $quiz->id;

        $this->courseId = $quiz->module->course_id;
        $this->moduleId = $quiz->module_id;
        $this->title = $quiz->title;
        $this->description = $quiz->description;
        $this->passingScore = $quiz->passing_score;
        $this->maxAttempts = $quiz->max_attempts;
        $this->timeLimitMinutes = $quiz->time_limit_minutes;
        $this->isRequired = $quiz->is_required;
        $this->isActive = $quiz->is_active;

        $this->lockedByAttempts = $quiz->hasAttempts();

        $this->questions = $quiz->questions->map(function ($question) {
            return [
                'question_text' => $question->question_text,
                'type' => $question->type,
                'points' => $question->points,
                'options' => $question->options->map(fn($o) => [
                    'option_text' => $o->option_text,
                    'is_correct' => $o->is_correct,
                ])->toArray(),
            ];
        })->toArray();

        $this->showModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    public function save()
    {
        if (!auth()->user()->can('manage quizzes')) {
            abort(403);
        }

        $this->validate([
            'courseId' => 'required|exists:courses,id',
            'moduleId' => 'required|exists:modules,id|unique:quizzes,module_id,' . $this->editingId,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passingScore' => 'required|integer|min:1|max:100',
            'maxAttempts' => 'required|integer|min:1|max:20',
            'timeLimitMinutes' => 'nullable|integer|min:1',
            'isRequired' => 'boolean',
            'isActive' => 'boolean',
        ], [
            'moduleId.unique' => 'This module already has a quiz assigned.',
        ]);

        if (!$this->lockedByAttempts) {
            $this->validateQuestions();
        }

        DB::transaction(function () {

            $quiz = Quiz::updateOrCreate(
                ['id' => $this->editingId],
                [
                    'module_id' => $this->moduleId,
                    'title' => $this->title,
                    'description' => $this->description,
                    'passing_score' => $this->passingScore,
                    'max_attempts' => $this->maxAttempts,
                    'time_limit_minutes' => $this->timeLimitMinutes ?: null,
                    'is_required' => $this->isRequired,
                    'is_active' => $this->isActive,
                    'created_by' => $this->editingId
                        ? Quiz::find($this->editingId)?->created_by
                        : auth()->id(),
                ]
            );

            if (!$this->lockedByAttempts) {

                // Full-replace: safe only while no attempts exist (guarded above)
                $quiz->questions()->delete();

                foreach ($this->questions as $qIndex => $questionData) {

                    $question = QuizQuestion::create([
                        'quiz_id' => $quiz->id,
                        'question_text' => $questionData['question_text'],
                        'type' => $questionData['type'],
                        'points' => $questionData['points'] ?: 1,
                        'question_order' => $qIndex + 1,
                    ]);

                    foreach ($questionData['options'] as $oIndex => $optionData) {
                        QuizOption::create([
                            'quiz_question_id' => $question->id,
                            'option_text' => $optionData['option_text'],
                            'is_correct' => (bool) $optionData['is_correct'],
                            'option_order' => $oIndex + 1,
                        ]);
                    }
                }
            }
        });

        $this->showModal = false;

        $this->dispatch(
            'notify',
            message: $this->editingId ? 'Quiz updated.' : 'Quiz created successfully.',
            type: 'success'
        );
    }

    /**
     * Cross-field validation the standard validator can't express cleanly:
     * every question needs ≥2 options and at least one correct answer.
     */
    protected function validateQuestions(): void
    {
        if (empty($this->questions)) {
            $this->addError('questions', 'Add at least one question.');
            throw \Illuminate\Validation\ValidationException::withMessages([
                'questions' => 'Add at least one question.',
            ]);
        }

        foreach ($this->questions as $qIndex => $question) {

            if (empty(trim($question['question_text'] ?? ''))) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "questions.$qIndex.question_text" => 'Question text is required.',
                ]);
            }

            $options = $question['options'] ?? [];

            if (count($options) < 2) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "questions.$qIndex.options" => 'Each question needs at least two options.',
                ]);
            }

            foreach ($options as $option) {
                if (empty(trim($option['option_text'] ?? ''))) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        "questions.$qIndex.options" => 'All options must have text.',
                    ]);
                }
            }

            $correctCount = collect($options)->where('is_correct', true)->count();

            if ($correctCount < 1) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "questions.$qIndex.options" => 'Mark at least one correct answer.',
                ]);
            }

            if ($question['type'] !== 'checkbox' && $correctCount > 1) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    "questions.$qIndex.options" => 'This question type allows only one correct answer.',
                ]);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function confirmDelete(int $id)
    {
        if (!auth()->user()->can('manage quizzes')) {
            abort(403);
        }

        $quiz = Quiz::findOrFail($id);

        if ($quiz->hasAttempts()) {

            $this->dispatch(
                'notify',
                message: 'Cannot delete students have already attempted this quiz.',
                type: 'error'
            );

            return;
        }

        $this->deleteId = $id;
        $this->deleteQuizName = $quiz->title;

        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $quiz = Quiz::findOrFail($this->deleteId);

        if ($quiz->hasAttempts()) {

            $this->dispatch(
                'notify',
                message: 'Cannot delete students have already attempted this quiz.',
                type: 'error'
            );

            $this->showDeleteModal = false;

            return;
        }

        $quiz->delete();

        $this->showDeleteModal = false;

        $this->dispatch('notify', message: 'Quiz deleted.', type: 'success');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;

        $this->deleteId = null;
        $this->deleteQuizName = '';
    }

    public function render()
    {
        $quizzes = Quiz::query()
            ->with(['module.course', 'createdBy'])
            ->whereHas('module.course', fn($q) => $q->visibleTo(auth()->user()))
            ->withCount('questions')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhereHas('module', fn($m) => $m->where('title', 'like', '%' . $this->search . '%'))
                        ->orWhereHas('module.course', fn($c) => $c->where('title', 'like', '%' . $this->search . '%'));
                });
            })
            ->when($this->courseFilter, function ($query) {
                $query->whereHas('module', fn($m) => $m->where('course_id', $this->courseFilter));
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.quizzes.index', [
            'quizzes' => $quizzes,
            'courses' => Course::active()->visibleTo(auth()->user())->orderBy('title')->get(),
            'availableModules' => $this->courseId
                ? Module::where('course_id', $this->courseId)->active()->orderBy('module_order')->get()
                : collect(),
            'allCourses' => Course::visibleTo(auth()->user())->orderBy('title')->get(),
            'questionTypes' => QuizQuestion::TYPES,
        ]);
    }
}
