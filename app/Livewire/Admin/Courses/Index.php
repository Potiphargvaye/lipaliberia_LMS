<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public bool $showModal = false;

    public $editingId = null;

    public $title = '';
    public $slug = '';

    public $category = '';
    public $group = '';
    public $groupLabel = '';
    public $programmeType = '';

    public $overview = '';
    public $targetAudience = '';
    public $entryRequirements = '';

    public $duration = '';
    public $schedule = '';
    public $fee = '';
    public $seats = '';

    public bool $isActive = true;

    public $deleteId = null;
    public $deleteCourseName = '';
    public bool $showDeleteModal = false;

    public $search = '';

    public $courseCategoryId = null;
    public $facilitatorIds = [];

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    public function updatingSearch()
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
        if (!auth()->user()->can('manage courses')) {
            abort(403);
        }


        $this->reset([
            'editingId',
            'title',
            'slug',
            'courseCategoryId',
            'facilitatorIds',
            'group',
            'groupLabel',
            'programmeType',
            'overview',
            'targetAudience',
            'entryRequirements',
            'duration',
            'schedule',
            'fee',
            'seats',
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
        if (!auth()->user()->can('manage courses')) {
            abort(403);
        }


        $course = Course::findOrFail($id);


        $this->editingId = $course->id;

        $this->title = $course->title;
        $this->slug = $course->slug;

        $this->courseCategoryId = $course->course_category_id;
        $this->facilitatorIds = $course->facilitators()->pluck('users.id')->toArray();
        $this->group = $course->group;
        $this->groupLabel = $course->group_label;
        $this->programmeType = $course->programme_type;

        $this->overview = $course->overview;
        $this->targetAudience = $course->target_audience;
        $this->entryRequirements = $course->entry_requirements;

        $this->duration = $course->duration;
        $this->schedule = $course->schedule;
        $this->fee = $course->fee;
        $this->seats = $course->seats;

        $this->isActive = $course->is_active;


        $this->showModal = true;
    }




    /*
    |--------------------------------------------------------------------------
    | Auto Generate Slug
    |--------------------------------------------------------------------------
    */

    public function updatedTitle($value)
    {
        if (!$this->editingId) {
            $this->slug = Str::slug($value);
        }
    }





    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    public function save()
    {
        if (!auth()->user()->can('manage courses')) {
            abort(403);
        }


        $this->validate([

            'title' => 'required|string|max:255',

            'slug' => 'required|string|max:255|alpha_dash|unique:courses,slug,' . $this->editingId,

            'courseCategoryId' => 'nullable|exists:course_categories,id',

            'programmeType' => 'nullable|string|max:255',

            'overview' => 'nullable|string',

            'duration' => 'nullable|string|max:255',

            'fee' => 'nullable|numeric|min:0',

            'seats' => 'nullable|integer|min:0',

            'isActive' => 'boolean',

        ]);



        $course = Course::updateOrCreate(

            ['id' => $this->editingId],

            [

                'title' => $this->title,

                'slug' => $this->slug,

                'course_category_id' => $this->courseCategoryId,

                'group' => $this->group,

                'group_label' => $this->groupLabel,

                'programme_type' => $this->programmeType,

                'overview' => $this->overview,

                'target_audience' => $this->targetAudience,

                'entry_requirements' => $this->entryRequirements,

                'duration' => $this->duration,

                'schedule' => $this->schedule,

                'fee' => $this->fee,

                'seats' => $this->seats,

                'is_active' => $this->isActive,

            ]

        );

        $course->facilitators()->sync($this->facilitatorIds);


        $this->showModal = false;


        $this->dispatch(
            'notify',
            message: $this->editingId
                ? 'Course updated.'
                : 'Course created.',
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
        if (!auth()->user()->can('manage courses')) {
            abort(403);
        }


        $course = Course::findOrFail($id);


        if (!$course->canBeDeleted()) {

            $this->dispatch(
                'notify',
                message: 'Cannot delete students are already enrolled in this course.',
                type: 'error'
            );

            return;
        }


        $this->deleteId = $id;
        $this->deleteCourseName = $course->title;

        $this->showDeleteModal = true;
    }



    public function delete()
    {
        $course = Course::findOrFail($this->deleteId);


        if (!$course->canBeDeleted()) {

            $this->dispatch(
                'notify',
                message: 'Cannot delete — students are already enrolled.',
                type: 'error'
            );

            $this->showDeleteModal = false;

            return;
        }


        $course->delete();


        $this->showDeleteModal = false;


        $this->dispatch(
            'notify',
            message: 'Course deleted.',
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
        $this->deleteCourseName = '';
    }



    public function render()
    {
        $courses = Course::query()
            ->with('courseCategory')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('programme_type', 'like', '%' . $this->search . '%')
                        ->orWhereHas('courseCategory', function ($catQuery) {
                            $catQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.courses.index', [
            'courses' => $courses,
            'categories' => \App\Models\CourseCategory::active()->orderBy('name')->get(),
            'facilitatorOptions' => \App\Models\User::role('Facilitator')->orderBy('name')->get(),
        ]);
    }
}
