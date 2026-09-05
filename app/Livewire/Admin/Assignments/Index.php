<?php

namespace App\Livewire\Admin\Assignments;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public bool $showModal = false;

    public $editingId = null;

    public $courseId = '';
    public $moduleId = '';
    public $title = '';
    public $instructions = '';
    public $contentType = 'text';
    public $contentText = '';
    public $contentFile = null;
    public $existingContentFilePath = null;
    public $dueDate = '';
    public bool $isRequired = true;
    public bool $isActive = true;

    public $deleteId = null;
    public $deleteAssignmentName = '';
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

    public function updatedContentType()
    {
        $this->contentText = '';
        $this->contentFile = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function openCreateModal()
    {
        if (!auth()->user()->can('manage assignments')) {
            abort(403);
        }

        $this->reset([
            'editingId',
            'courseId',
            'moduleId',
            'title',
            'instructions',
            'contentText',
            'contentFile',
            'existingContentFilePath',
            'dueDate',
        ]);

        $this->contentType = 'text';
        $this->isRequired = true;
        $this->isActive = true;

        $this->showModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function openEditModal(int $id)
    {
        if (!auth()->user()->can('manage assignments')) {
            abort(403);
        }

        $assignment = Assignment::with('module')->findOrFail($id);

        $this->editingId = $assignment->id;

        $this->courseId = $assignment->module->course_id;
        $this->moduleId = $assignment->module_id;
        $this->title = $assignment->title;
        $this->instructions = $assignment->instructions;
        $this->contentType = $assignment->content_type;
        $this->contentText = $assignment->content_text ?? '';
        $this->contentFile = null;
        $this->existingContentFilePath = $assignment->content_file_path;
        $this->dueDate = $assignment->due_date?->format('Y-m-d\TH:i');
        $this->isRequired = $assignment->is_required;
        $this->isActive = $assignment->is_active;

        $this->showModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    public function save()
    {
        if (!auth()->user()->can('manage assignments')) {
            abort(403);
        }

        $rules = [
            'courseId' => 'required|exists:courses,id',
            'moduleId' => 'required|exists:modules,id|unique:assignments,module_id,' . $this->editingId,
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'contentType' => 'required|in:text,file',
            'dueDate' => 'nullable|date',
            'isRequired' => 'boolean',
            'isActive' => 'boolean',
        ];

        if ($this->contentType === 'text') {
            $rules['contentText'] = 'required|string';
        } else {
            $requiredRule = ($this->editingId && $this->existingContentFilePath) ? 'nullable' : 'required';
            $rules['contentFile'] = $requiredRule . '|file|mimes:pdf,doc,docx,ppt,pptx|max:30720'; // 30MB
        }

        $this->validate($rules, [
            'moduleId.unique' => 'This module already has an assignment assigned.',
        ]);

        $filePath = $this->existingContentFilePath;

        if ($this->contentType === 'file' && $this->contentFile) {

            if ($this->existingContentFilePath) {
                Storage::disk('public')->delete($this->existingContentFilePath);
            }

            $filePath = $this->contentFile->store('assignments/briefs', 'public');
        }

        Assignment::updateOrCreate(

            ['id' => $this->editingId],

            [
                'module_id' => $this->moduleId,
                'title' => $this->title,
                'instructions' => $this->instructions,
                'content_type' => $this->contentType,
                'content_text' => $this->contentType === 'text' ? $this->contentText : null,
                'content_file_path' => $this->contentType === 'file' ? $filePath : null,
                'due_date' => $this->dueDate ?: null,
                'is_required' => $this->isRequired,
                'is_active' => $this->isActive,
                'created_by' => $this->editingId
                    ? Assignment::find($this->editingId)?->created_by
                    : auth()->id(),
            ]
        );

        $this->showModal = false;

        $this->dispatch(
            'notify',
            message: $this->editingId ? 'Assignment updated.' : 'Assignment created successfully.',
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
        if (!auth()->user()->can('manage assignments')) {
            abort(403);
        }

        $assignment = Assignment::findOrFail($id);

        if ($assignment->submissions()->exists()) {

            $this->dispatch(
                'notify',
                message: 'Cannot delete — students have already submitted this assignment.',
                type: 'error'
            );

            return;
        }

        $this->deleteId = $id;
        $this->deleteAssignmentName = $assignment->title;

        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $assignment = Assignment::findOrFail($this->deleteId);

        if ($assignment->submissions()->exists()) {

            $this->dispatch(
                'notify',
                message: 'Cannot delete students have already submitted this assignment.',
                type: 'error'
            );

            $this->showDeleteModal = false;

            return;
        }

        if ($assignment->content_file_path) {
            Storage::disk('public')->delete($assignment->content_file_path);
        }

        $assignment->delete();

        $this->showDeleteModal = false;

        $this->dispatch('notify', message: 'Assignment deleted.', type: 'success');
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
        $this->deleteAssignmentName = '';
    }



    public function render()
    {
        $assignments = Assignment::query()
            ->with(['module.course', 'createdBy'])
            ->whereHas('module.course', fn($q) => $q->visibleTo(auth()->user()))
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

        return view('livewire.admin.assignments.index', [
            'assignments' => $assignments,
            'courses' => Course::active()->visibleTo(auth()->user())->orderBy('title')->get(),
            'availableModules' => $this->courseId
                ? Module::where('course_id', $this->courseId)->active()->orderBy('module_order')->get()
                : collect(),
            'allCourses' => Course::visibleTo(auth()->user())->orderBy('title')->get(),
        ]);
    }
}
