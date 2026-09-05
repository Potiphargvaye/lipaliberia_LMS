<?php

namespace App\Livewire\Admin\LearningMaterials;

use App\Models\Course;
use App\Models\LearningMaterial;
use App\Models\Module;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public bool $showModal = false;

    public $editingId = null;

    // Modal form fields
    public $courseId = '';
    public $moduleId = '';
    public $type = '';
    public $title = '';
    public $file = null;
    public $existingFilePath = null;
    public $externalUrl = '';
    public $content = '';
    public $description = '';
    public $materialOrder = '';
    public bool $isActive = true;

    // Delete modal
    public $deleteId = null;
    public $deleteMaterialName = '';
    public bool $showDeleteModal = false;

    // Preview modal
    public $showPreviewModal = false;
    public $previewMaterial = null;

    // Search & filters
    public $search = '';
    public $courseFilter = '';
    public $moduleFilter = '';
    public $typeFilter = '';
    public $statusFilter = '';

    /*
    |--------------------------------------------------------------------------
    | Search / Filter reactivity
    |--------------------------------------------------------------------------
    */

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedCourseFilter()
    {
        $this->moduleFilter = '';
        $this->resetPage();
    }

    public function updatedModuleFilter()
    {
        $this->resetPage();
    }

    public function updatedTypeFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Cascading Course -> Module (modal)
    |--------------------------------------------------------------------------
    */

    public function updatedCourseId()
    {
        $this->moduleId = '';
    }

    public function updatedType()
    {
        // Clear values tied to a different type when the type changes,
        // so stale data never gets saved against the wrong field.
        $this->file = null;
        $this->externalUrl = '';
        $this->content = '';
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function openCreateModal()
    {
        if (!auth()->user()->can('manage learning materials')) {
            abort(403);
        }

        $this->reset([
            'editingId',
            'courseId',
            'moduleId',
            'type',
            'title',
            'file',
            'existingFilePath',
            'externalUrl',
            'content',
            'description',
            'materialOrder',
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
        if (!auth()->user()->can('manage learning materials')) {
            abort(403);
        }

        $material = LearningMaterial::with('module')->findOrFail($id);

        $this->editingId = $material->id;

        $this->courseId = $material->module->course_id;
        $this->moduleId = $material->module_id;
        $this->type = $material->type;
        $this->title = $material->title;

        $this->file = null;
        $this->existingFilePath = $material->file_path;

        $this->externalUrl = $material->external_url ?? '';
        $this->content = $material->content ?? '';
        $this->description = $material->description ?? '';
        $this->materialOrder = $material->material_order;
        $this->isActive = $material->is_active;

        $this->showModal = true;
    }

    /*
    |--------------------------------------------------------------------------
    | Save
    |--------------------------------------------------------------------------
    */

    public function save()
    {
        if (!auth()->user()->can('manage learning materials')) {
            abort(403);
        }

        $rules = [
            'courseId' => 'required|exists:courses,id',
            'moduleId' => 'required|exists:modules,id',
            'type' => 'required|in:' . implode(',', array_keys(LearningMaterial::TYPE_LABELS)),
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'materialOrder' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('learning_materials', 'material_order')
                    ->where('module_id', $this->moduleId)
                    ->ignore($this->editingId),
            ],
            'isActive' => 'boolean',
        ];

        if (in_array($this->type, LearningMaterial::FILE_TYPES, true)) {

            $fileRule = LearningMaterial::FILE_RULES[$this->type] ?? 'file';

            // Required on create, or on edit only if no existing file is kept
            $requiredRule = ($this->editingId && $this->existingFilePath) ? 'nullable' : 'required';

            $rules['file'] = $requiredRule . '|file|' . $fileRule;
        } elseif ($this->type === 'external_link') {

            $rules['externalUrl'] = 'required|url|max:2048';
        } elseif ($this->type === 'text') {

            $rules['content'] = 'required|string';
        }

        $this->validate($rules, [
            'materialOrder.unique' => 'This material order is already used within the selected module.',
        ]);

        $filePath = $this->existingFilePath;

        if (in_array($this->type, LearningMaterial::FILE_TYPES, true) && $this->file) {

            // Replace: remove the old file before storing the new one
            if ($this->existingFilePath) {
                Storage::disk('public')->delete($this->existingFilePath);
            }

            $filePath = $this->file->store('learning-materials/' . $this->type, 'public');
        }

        LearningMaterial::updateOrCreate(

            ['id' => $this->editingId],

            [
                'module_id' => $this->moduleId,
                'title' => $this->title,
                'type' => $this->type,

                'file_path' => in_array($this->type, LearningMaterial::FILE_TYPES, true) ? $filePath : null,
                'external_url' => $this->type === 'external_link' ? $this->externalUrl : null,
                'content' => $this->type === 'text' ? $this->content : null,

                'description' => $this->description,
                'material_order' => $this->materialOrder,
                'is_active' => $this->isActive,

                'created_by' => $this->editingId
                    ? LearningMaterial::find($this->editingId)?->created_by
                    : auth()->id(),
            ]
        );

        $this->showModal = false;

        $this->dispatch(
            'notify',
            message: $this->editingId
                ? 'Learning material updated.'
                : 'Learning material created successfully.',
            type: 'success'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Preview
    |--------------------------------------------------------------------------
    */

    public function openPreviewModal(int $id)
    {
        $this->previewMaterial = LearningMaterial::with('module.course')->findOrFail($id);
        $this->showPreviewModal = true;
    }

    public function closePreviewModal()
    {
        $this->showPreviewModal = false;
        $this->previewMaterial = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function confirmDelete(int $id)
    {
        if (!auth()->user()->can('manage learning materials')) {
            abort(403);
        }

        $material = LearningMaterial::findOrFail($id);

        if (!$material->canBeDeleted()) {

            $this->dispatch(
                'notify',
                message: 'Cannot delete this learning material.',
                type: 'error'
            );

            return;
        }

        $this->deleteId = $id;
        $this->deleteMaterialName = $material->title;

        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $material = LearningMaterial::findOrFail($this->deleteId);

        if (!$material->canBeDeleted()) {

            $this->dispatch(
                'notify',
                message: 'Cannot delete this learning material.',
                type: 'error'
            );

            $this->showDeleteModal = false;

            return;
        }

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        $this->showDeleteModal = false;

        $this->dispatch(
            'notify',
            message: 'Learning material deleted.',
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
        $this->deleteMaterialName = '';
    }

    /*
    |--------------------------------------------------------------------------
    | Form helpers (used in the blade view for the dynamic file input)
    |--------------------------------------------------------------------------
    */

    public function fileAccept(): string
    {
        return match ($this->type) {
            'video' => '.mp4,.mov,.webm',
            'pdf' => '.pdf',
            'powerpoint' => '.ppt,.pptx',
            'word' => '.doc,.docx',
            'downloadable' => '.zip,.rar',
            default => '*',
        };
    }

    public function fileSizeLabel(): string
    {
        return match ($this->type) {
            'video' => 'Max 100MB — MP4, MOV, or WEBM',
            'pdf' => 'Max 20MB — PDF only',
            'powerpoint' => 'Max 30MB — PPT or PPTX',
            'word' => 'Max 15MB — DOC or DOCX',
            'downloadable' => 'Max 50MB — ZIP or RAR',
            default => '',
        };
    }

    public function render()
    {
        $materials = LearningMaterial::query()
            ->with(['module.course', 'createdBy'])
            ->whereHas('module.course', fn($q) => $q->visibleTo(auth()->user()))
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhereHas('module', function ($moduleQuery) {
                            $moduleQuery->where('title', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('module.course', function ($courseQuery) {
                            $courseQuery->where('title', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->courseFilter, function ($query) {
                $query->whereHas('module', function ($moduleQuery) {
                    $moduleQuery->where('course_id', $this->courseFilter);
                });
            })
            ->when($this->moduleFilter, function ($query) {
                $query->where('module_id', $this->moduleFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter === 'active');
            })
            ->orderBy('module_id')
            ->orderBy('material_order')
            ->paginate(10);

        return view('livewire.admin.learning-materials.index', [

            'materials' => $materials,

            // Modal course dropdown — active + scoped
            'courses' => Course::active()->visibleTo(auth()->user())->orderBy('title')->get(),

            // Modal module dropdown — scoped to the selected course. No extra
            // scope needed here: courseId can only ever be a course already
            // scoped via the `courses` dropdown above, so this is safe by
            // construction.
            'availableModules' => $this->courseId
                ? Module::where('course_id', $this->courseId)->active()->orderBy('module_order')->get()
                : collect(),

            // Filter dropdowns — scoped so a facilitator can't filter by, or
            // discover the existence of, courses/modules outside their access
            'allCourses' => Course::visibleTo(auth()->user())->orderBy('title')->get(),

            'filterModules' => $this->courseFilter
                ? Module::where('course_id', $this->courseFilter)->orderBy('module_order')->get()
                : Module::whereHas('course', fn($q) => $q->visibleTo(auth()->user()))->orderBy('module_order')->get(),

            'typeLabels' => LearningMaterial::TYPE_LABELS,

        ]);
    }
}
