<?php

namespace App\Livewire\Admin\Modules;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public bool $showModal = false;

    public $editingId = null;

    public $courseId = '';
    public $title = '';
    public $moduleOrder = '';
    public bool $isActive = true;

    public $deleteId = null;
    public $deleteModuleName = '';
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

    public function updatingCourseFilter()
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function openCreateModal()
    {
        if (!auth()->user()->can('manage modules')) {
            abort(403);
        }

        $this->reset([
            'editingId',
            'courseId',
            'title',
            'moduleOrder',
        ]);

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
        if (!auth()->user()->can('manage modules')) {
            abort(403);
        }

        $module = Module::findOrFail($id);

        $this->editingId = $module->id;

        $this->courseId = $module->course_id;
        $this->title = $module->title;
        $this->moduleOrder = $module->module_order;
        $this->isActive = $module->is_active;

        $this->showModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    public function save()
    {
        if (!auth()->user()->can('manage modules')) {
            abort(403);
        }

        $this->validate([

            'courseId' => 'required|exists:courses,id',

            'title' => 'required|string|max:255',

            'moduleOrder' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('modules', 'module_order')
                    ->where('course_id', $this->courseId)
                    ->ignore($this->editingId),
            ],

            'isActive' => 'boolean',

        ], [
            'moduleOrder.unique' => 'This module order is already used for the selected course.',
        ]);

        Module::updateOrCreate(

            ['id' => $this->editingId],

            [

                'course_id' => $this->courseId,

                'title' => $this->title,

                'module_order' => $this->moduleOrder,

                'is_active' => $this->isActive,

                'created_by' => $this->editingId
                    ? Module::find($this->editingId)?->created_by
                    : auth()->id(),

            ]

        );

        $this->showModal = false;

        $this->dispatch(
            'notify',
            message: $this->editingId
                ? 'Module updated.'
                : 'Module created successfully.',
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
        if (!auth()->user()->can('manage modules')) {
            abort(403);
        }

        $module = Module::findOrFail($id);

        if (!$module->canBeDeleted()) {

            $this->dispatch(
                'notify',
                message: 'Cannot delete this module has learning materials attached.',
                type: 'error'
            );

            return;
        }

        $this->deleteId = $id;
        $this->deleteModuleName = 'Module ' . $module->module_order . ': ' . $module->title;

        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $module = Module::findOrFail($this->deleteId);

        if (!$module->canBeDeleted()) {

            $this->dispatch(
                'notify',
                message: 'Cannot delete this module has learning materials attached.',
                type: 'error'
            );

            $this->showDeleteModal = false;

            return;
        }

        $module->delete();

        $this->showDeleteModal = false;

        $this->dispatch(
            'notify',
            message: 'Success Module deleted.',
            type: 'success'
        );
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
        $this->deleteModuleName = '';
    }

    public function render()
    {
        $modules = Module::query()
            ->with(['course', 'createdBy'])
            ->whereHas('course', fn($q) => $q->visibleTo(auth()->user()))
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhereHas('course', function ($courseQuery) {
                            $courseQuery->where('title', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->courseFilter, function ($query) {
                $query->where('course_id', $this->courseFilter);
            })
            ->orderBy('course_id')
            ->orderBy('module_order')
            ->paginate(10);

        return view('livewire.admin.modules.index', [

            'modules' => $modules,

            // Modal dropdown — active courses only, scoped to what this user can manage
            'courses' => Course::active()->visibleTo(auth()->user())->orderBy('title')->get(),

            // Filter dropdown — same scope, so a facilitator can't filter by
            // a course they aren't assigned to
            'allCourses' => Course::visibleTo(auth()->user())->orderBy('title')->get(),

        ]);
    }
}
