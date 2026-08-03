<?php

namespace App\Livewire\Admin\Students;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    /*
    |-------------------------------------------------------------------------- ww
    | UI State
    |--------------------------------------------------------------------------
    */

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Confirmation (pattern carried over from the old Index component,
    | rebuilt against the new schema — Student delete now cascades through
    | the User account, which cascades to Applications/Enrollments via FK)
    |--------------------------------------------------------------------------
    */

    public $showDeleteModal = false;
    public $deleteStudentId;
    public $deleteStudentName;

    public function confirmDelete($id)
    {
        if (! auth()->user()->can('delete students')) {
            abort(403);
        }

        $student = Student::findOrFail($id);

        $this->deleteStudentId = $student->id;
        $this->deleteStudentName = $student->name;
        $this->showDeleteModal = true;
    }

    public function deleteStudent()
    {
        if (! auth()->user()->can('delete students')) {
            abort(403);
        }

        $student = Student::with('user')->findOrFail($this->deleteStudentId);

        // Deleting the User cascades to Student, which cascades to
        // Applications/Enrollments (see migration FK definitions) — this
        // keeps the login account and profile as a single unit, since a
        // Student can never exist without its User per our architecture.
        $student->user?->delete();

        $this->showDeleteModal = false;
        $this->deleteStudentId = null;
        $this->deleteStudentName = null;

        $this->dispatch(
            'notify',
            message: 'Student record deleted successfully!',
            type: 'success'
        );
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deleteStudentId = null;
        $this->deleteStudentName = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $students = Student::query()
            ->with('user')
            ->withCount(['applications', 'enrollments'])
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('mobile_number', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($query) {
                            $query->where('email', 'like', "%{$this->search}%")
                                ->orWhere('registration_id', 'like', "%{$this->search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.students.index', [
            'students' => $students,
            'canView' => auth()->user()->can('view students'),
            'canEdit' => auth()->user()->can('edit students'),
            'canDelete' => auth()->user()->can('delete students'),
        ]);
    }
}
