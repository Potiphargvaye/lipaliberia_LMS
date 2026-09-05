<?php

namespace App\Livewire\Admin\LiveClasses;

use App\Models\Cohort;
use App\Models\Course;
use App\Models\LiveClass;
use App\Models\Module;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    /*
    |--------------------------------------------------------------------------
    | Modal state
    |--------------------------------------------------------------------------
    */

    public bool $showModal = false;
    public $editingId = null;

    public bool $showViewModal = false;
    public $viewingLiveClass = null;

    public bool $showDeleteModal = false;
    public $deleteId = null;
    public $deleteTitle = '';

    /*
    |--------------------------------------------------------------------------
    | Form fields
    |--------------------------------------------------------------------------
    */

    public $courseId = null;
    public $moduleId = null;
    public $cohortId = null;
    public $facilitatorId = null;

    public $title = '';
    public $description = '';

    public $date = '';
    public $startTime = '';
    public $endTime = '';

    public $platform = '';
    public $meetingUrl = '';
    public $status = 'scheduled';

    /*
    |--------------------------------------------------------------------------
    | Search / Filters
    |--------------------------------------------------------------------------
    */

    public $search = '';

    // Only ever applied for users with 'view all course records' —
    // see render(). A scoped facilitator cannot use these to probe
    // for courses/facilitators outside their assigned courses because
    // the underlying query is always visibleTo()-scoped first, and the
    // filter option lists themselves are never built for scoped users.
    public $courseFilter = '';
    public $facilitatorFilter = '';
    public $cohortFilter = '';

    // Safe for everyone — status/date don't reveal anything about
    // courses the user isn't already scoped to.
    public $statusFilter = '';
    public $dateFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCourseFilter()
    {
        $this->resetPage();
    }

    public function updatingFacilitatorFilter()
    {
        $this->resetPage();
    }

    public function updatingCohortFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFilter()
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Course -> Module / Facilitator dependent selects
    |--------------------------------------------------------------------------
    */

    public function updatedCourseId($value)
    {
        // Selecting a different course invalidates whatever module/facilitator
        // was chosen for the previous course.
        $this->moduleId = null;
        $this->facilitatorId = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function openCreateModal()
    {
        if (! auth()->user()->can('manage live classes')) {
            abort(403);
        }

        $this->reset([
            'editingId',
            'courseId',
            'moduleId',
            'cohortId',
            'facilitatorId',
            'title',
            'description',
            'date',
            'startTime',
            'endTime',
            'platform',
            'meetingUrl',
        ]);

        $this->status = 'scheduled';

        $this->showModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function openEditModal(int $id)
    {
        if (! auth()->user()->can('manage live classes')) {
            abort(403);
        }

        // Scoped lookup — a facilitator manually changing the id in a
        // wire:click payload / replaying a request for an unrelated
        // course's live class gets a 404 here, never the record.
        $liveClass = LiveClass::visibleTo(auth()->user())->findOrFail($id);

        $this->editingId = $liveClass->id;
        $this->courseId = $liveClass->course_id;
        $this->moduleId = $liveClass->module_id;
        $this->cohortId = $liveClass->cohort_id;
        $this->facilitatorId = $liveClass->facilitator_id;

        $this->title = $liveClass->title;
        $this->description = $liveClass->description;

        $this->date = $liveClass->date->format('Y-m-d');
        $this->startTime = substr($liveClass->start_time, 0, 5);
        $this->endTime = substr($liveClass->end_time, 0, 5);

        $this->platform = $liveClass->platform;
        $this->meetingUrl = $liveClass->meeting_url;
        $this->status = $liveClass->status;

        $this->showModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | View (read-only)
    |--------------------------------------------------------------------------
    */

    public function openViewModal(int $id)
    {
        $this->viewingLiveClass = LiveClass::visibleTo(auth()->user())
            ->with(['course', 'module', 'cohort', 'facilitator'])
            ->findOrFail($id);

        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->viewingLiveClass = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    public function save()
    {
        if (! auth()->user()->can('manage live classes')) {
            abort(403);
        }

        $this->validate([
            'courseId' => 'required|exists:courses,id',
            'moduleId' => 'nullable|exists:modules,id',
            'cohortId' => 'nullable|exists:cohorts,id',
            'facilitatorId' => 'required|exists:users,id',

            'title' => 'required|string|max:255',
            'description' => 'nullable|string',

            'date' => 'required|date',
            'startTime' => 'required|date_format:H:i',
            'endTime' => 'required|date_format:H:i|after:startTime',

            'platform' => 'required|in:google_meet,zoom,teams,other',
            'meetingUrl' => 'required|url|max:500',

            'status' => 'required|in:scheduled,live,completed,cancelled',
        ]);

        // Re-verify against visibleTo(), not just the exists() rule above —
        // exists() only proves the course is real, not that this user is
        // allowed to schedule a live class for it.
        $course = Course::visibleTo(auth()->user())->find($this->courseId);

        if (! $course) {
            abort(403, 'You are not authorized to schedule a live class for this course.');
        }

        if ($this->moduleId && ! $course->modules()->where('id', $this->moduleId)->exists()) {
            $this->addError('moduleId', 'The selected module does not belong to the selected course.');
            return;
        }

        if (! $course->facilitators()->where('users.id', $this->facilitatorId)->exists()) {
            $this->addError('facilitatorId', 'The selected facilitator is not assigned to this course.');
            return;
        }

        $data = [
            'course_id' => $this->courseId,
            'module_id' => $this->moduleId ?: null,
            'cohort_id' => $this->cohortId ?: null,
            'facilitator_id' => $this->facilitatorId,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'platform' => $this->platform,
            'meeting_url' => $this->meetingUrl,
            'status' => $this->status,
        ];

        if ($this->editingId) {
            // Scoped lookup again on save, not just on open — closes the
            // window where someone could open a legitimate record, then
            // the id gets swapped before submit.
            $liveClass = LiveClass::visibleTo(auth()->user())->findOrFail($this->editingId);
            $liveClass->update($data);
        } else {
            // created_by set once, on creation, purely for the audit trail.
            LiveClass::create($data + ['created_by' => auth()->id()]);
        }

        $this->showModal = false;

        $this->dispatch(
            'notify',
            message: $this->editingId ? 'Live class updated.' : 'Live class scheduled.',
            type: 'success'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function confirmDelete(int $id)
    {
        if (! auth()->user()->can('manage live classes')) {
            abort(403);
        }

        $liveClass = LiveClass::visibleTo(auth()->user())->findOrFail($id);

        $this->deleteId = $id;
        $this->deleteTitle = $liveClass->title;

        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if (! auth()->user()->can('manage live classes')) {
            abort(403);
        }

        $liveClass = LiveClass::visibleTo(auth()->user())->findOrFail($this->deleteId);
        $liveClass->delete();

        $this->showDeleteModal = false;

        $this->dispatch('notify', message: 'Live class deleted.', type: 'success');
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
        $this->deleteTitle = '';
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $user = auth()->user();
        $isUnrestricted = $user->can('view all course records');

        $liveClasses = LiveClass::query()
            ->with(['course', 'module', 'cohort', 'facilitator'])
            ->visibleTo($user)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhereHas('course', fn($c) => $c->where('title', 'like', '%' . $this->search . '%'));
                });
            })
            // Course/Facilitator/Cohort filters are only ever applied for
            // unrestricted users. For a scoped facilitator, courseFilter
            // etc. would be empty anyway since the option lists that feed
            // them are never built for scoped users (see below) — this
            // `$isUnrestricted &&` guard is defense in depth.
            ->when($isUnrestricted && $this->courseFilter, fn($q) => $q->where('course_id', $this->courseFilter))
            ->when($isUnrestricted && $this->facilitatorFilter, fn($q) => $q->where('facilitator_id', $this->facilitatorFilter))
            ->when($isUnrestricted && $this->cohortFilter, fn($q) => $q->where('cohort_id', $this->cohortFilter))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->dateFilter, fn($q) => $q->whereDate('date', $this->dateFilter))
            ->orderBy('date')
            ->orderBy('start_time')
            ->paginate(10);

        return view('livewire.admin.live-classes.index', [
            'liveClasses' => $liveClasses,
            'isUnrestricted' => $isUnrestricted,

            // Course dropdown for the create/edit form — already scoped,
            // so a facilitator can only ever pick a course they're on.
            'courseOptions' => Course::visibleTo($user)->orderBy('title')->get(),

            // Dependent dropdowns for the currently selected course.
            'moduleOptions' => $this->courseId
                ? Module::where('course_id', $this->courseId)->orderBy('module_order')->get()
                : collect(),

            'facilitatorOptions' => $this->courseId
                ? (Course::visibleTo($user)->find($this->courseId)?->facilitators()->orderBy('name')->get() ?? collect())
                : collect(),

            'cohortOptions' => Cohort::ordered()->get(),

            // Filter option lists — only ever built when unrestricted, so
            // a scoped facilitator's browser never even receives the
            // names of courses/facilitators outside their scope.
            'filterCourseOptions' => $isUnrestricted ? Course::orderBy('title')->get() : collect(),
            'filterFacilitatorOptions' => $isUnrestricted ? User::role('Facilitator')->orderBy('name')->get() : collect(),
        ]);
    }
}
