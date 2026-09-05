<?php

namespace App\Livewire\Admin\CourseCategories;

use App\Models\CourseCategory;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public bool $showModal = false;

    public $editingId = null;

    public $name = '';
    public $slug = '';
    public $image = null;         // uploaded file (new)
    public $existingImage = null; // current stored path when editing

    public bool $isActive = true;

    public $deleteId = null;
    public $deleteCategoryName = '';
    public bool $showDeleteModal = false;

    public $search = '';

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
        if (!auth()->user()->can('manage course categories')) {
            abort(403);
        }

        $this->reset([
            'editingId',
            'name',
            'slug',
            'image',
            'existingImage',
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
        if (!auth()->user()->can('manage course categories')) {
            abort(403);
        }

        $category = CourseCategory::findOrFail($id);

        $this->editingId = $category->id;

        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->existingImage = $category->image;
        $this->image = null;

        $this->isActive = $category->is_active;

        $this->showModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Auto Generate Slug
    |--------------------------------------------------------------------------
    */

    public function updatedName($value)
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
        if (!auth()->user()->can('manage course categories')) {
            abort(403);
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|alpha_dash|unique:course_categories,slug,' . $this->editingId,
            'image' => 'nullable|image|max:2048',
            'isActive' => 'boolean',
        ]);

        $imagePath = $this->existingImage;

        if ($this->image) {
            $imagePath = $this->image->store('course-categories', 'public');
        }

        $category = CourseCategory::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'slug' => $this->slug,
                'image' => $imagePath,
                'is_active' => $this->isActive,
                'created_by' => $this->editingId
                    ? CourseCategory::find($this->editingId)?->created_by
                    : auth()->id(),
            ]
        );

        $this->showModal = false;

        $this->dispatch(
            'notify',
            message: $this->editingId
                ? 'Category updated.'
                : 'Category created.',
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
        if (!auth()->user()->can('manage course categories')) {
            abort(403);
        }

        $category = CourseCategory::findOrFail($id);

        if (!$category->canBeDeleted()) {
            $this->dispatch(
                'notify',
                message: 'Cannot delete — courses are already assigned to this category.',
                type: 'error'
            );

            return;
        }

        $this->deleteId = $id;
        $this->deleteCategoryName = $category->name;

        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $category = CourseCategory::findOrFail($this->deleteId);

        if (!$category->canBeDeleted()) {
            $this->dispatch(
                'notify',
                message: 'Cannot delete — courses are already assigned to this category.',
                type: 'error'
            );

            $this->showDeleteModal = false;

            return;
        }

        $category->delete();

        $this->showDeleteModal = false;

        $this->dispatch(
            'notify',
            message: 'Category deleted.',
            type: 'success'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Active (Archive-style quick action)
    |--------------------------------------------------------------------------
    */

    public function toggleActive(int $id)
    {
        if (!auth()->user()->can('manage course categories')) {
            abort(403);
        }

        $category = CourseCategory::findOrFail($id);
        $category->update(['is_active' => !$category->is_active]);

        $this->dispatch(
            'notify',
            message: $category->is_active ? 'Category activated.' : 'Category archived.',
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
        $this->deleteCategoryName = '';
    }

    public function render()
    {
        $categories = CourseCategory::query()
            ->with('creator')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->withCount('courses')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.course-categories.index', [
            'categories' => $categories,
        ]);
    }
}
