<?php

namespace App\Livewire\Admin\Fees;

use App\Models\Cohort;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\FeeAssignment;
use App\Models\FeeCategory;
use App\Models\FeePayment;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    /*
    |--------------------------------------------------------------------------
    | UI State — category tabs, search, course/cohort filter
    |--------------------------------------------------------------------------
    */

    public string $categoryFilter = 'all';

    public string $search = '';

    public $courseFilter = '';
    public $cohortFilter = '';

    public function mount()
    {
        $this->cohortFilter = Cohort::where('is_active', true)
            ->orderBy('sort_order')
            ->value('id');
    }

    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCourseFilter()
    {
        $this->resetPage();
    }

    public function updatedCohortFilter()
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Assign Fee — enrollment is always pre-selected from the row (an
    | enrollment already carries student + course + cohort together, so
    | there's nothing left to pick beyond category/amount/due date).
    |--------------------------------------------------------------------------
    */

    public bool $showAssignModal = false;
    public $assignEnrollmentId;
    public $assignStudentName;
    public $assignCourseName;
    public $assignCohortName;
    public $assignFeeCategoryId = '';
    public $assignInstallmentNumber = '';
    public $assignAmount = '';
    public $assignDueDate = '';
    public $assignRemarks = '';

    public function openAssignModal(int $enrollmentId)
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $enrollment = Enrollment::with(['student', 'course', 'cohort'])->findOrFail($enrollmentId);

        $this->assignEnrollmentId = $enrollment->id;
        $this->assignStudentName = $enrollment->student->name;
        $this->assignCourseName = $enrollment->course->title ?? '—';
        $this->assignCohortName = $enrollment->cohort->name ?? '—';
        // Defaults to whichever category tab is active, if a real one is selected.
        $this->assignFeeCategoryId = $this->categoryFilter !== 'all' ? $this->categoryFilter : '';
        $this->assignInstallmentNumber = '';
        $this->assignAmount = '';
        $this->assignDueDate = '';
        $this->assignRemarks = '';
        $this->showAssignModal = true;
    }

    public function closeAssignModal()
    {
        $this->showAssignModal = false;
        $this->resetErrorBag();
    }

    public function saveAssignment()
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $this->validate([
            'assignFeeCategoryId' => 'required|exists:fee_categories,id',
            'assignInstallmentNumber' => 'nullable|string|max:255',
            'assignAmount' => 'required|numeric|min:0.01',
            'assignDueDate' => 'required|date',
            'assignRemarks' => 'nullable|string',
        ]);

        FeeAssignment::create([
            'enrollment_id' => $this->assignEnrollmentId,
            'fee_category_id' => $this->assignFeeCategoryId,
            'installment_number' => $this->assignInstallmentNumber ?: null,
            'amount' => $this->assignAmount,
            'due_date' => $this->assignDueDate,
            'remarks' => $this->assignRemarks,
            'status' => 'pending',
            'assigned_by' => auth()->id(),
        ]);

        $this->showAssignModal = false;

        $this->dispatch('notify', message: "Fee assigned to {$this->assignStudentName}.", type: 'success');
    }

    /*
    |--------------------------------------------------------------------------
    | Record Payment — enrollment pre-selected, then a short dropdown of
    | only THAT enrollment's own outstanding assignments.
    |--------------------------------------------------------------------------
    */

    public bool $showPaymentModal = false;
    public $paymentEnrollmentId;
    public $paymentStudentName;
    public $paymentOutstandingAssignments = [];
    public $paymentAssignmentId = '';
    public $paymentAmountPaid = '';
    public $paymentDate = '';
    public $paymentMethod = '';
    public $paymentReferenceNumber = '';
    public $paymentRemarks = '';

    // Set after a successful save so the modal can show a "Receipt ready" state.
    public $lastReceiptId = null;

    public function openPaymentModal(int $enrollmentId)
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $enrollment = Enrollment::with('student')->findOrFail($enrollmentId);

        $this->paymentEnrollmentId = $enrollment->id;
        $this->paymentStudentName = $enrollment->student->name;
        $this->paymentOutstandingAssignments = FeeAssignment::where('enrollment_id', $enrollment->id)
            ->where('status', '!=', 'paid')
            ->with('feeCategory')
            ->orderByDesc('due_date')
            ->get();
        $this->paymentAssignmentId = '';
        $this->paymentAmountPaid = '';
        $this->paymentDate = now()->format('Y-m-d');
        $this->paymentMethod = '';
        $this->paymentReferenceNumber = '';
        $this->paymentRemarks = '';
        $this->lastReceiptId = null;
        $this->showPaymentModal = true;
    }

    public function getSelectedAssignmentProperty()
    {
        if (! $this->paymentAssignmentId) {
            return null;
        }

        return FeeAssignment::with('feeCategory')->find($this->paymentAssignmentId);
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->lastReceiptId = null;
        $this->resetErrorBag();
    }

    public function savePayment()
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $assignment = FeeAssignment::findOrFail($this->paymentAssignmentId);
        $balance = (float) $assignment->balance();

        $this->validate([
            'paymentAssignmentId' => 'required|exists:fee_assignments,id',
            'paymentAmountPaid' => "required|numeric|min:0.01|max:{$balance}",
            'paymentDate' => 'required|date',
            'paymentMethod' => 'required|string|max:255',
            'paymentReferenceNumber' => 'nullable|string|max:255',
            'paymentRemarks' => 'required|string|min:3',
        ], [
            'paymentAmountPaid.max' => 'Amount paid cannot exceed the outstanding balance of $' . number_format($balance, 2) . '.',
        ]);

        $payment = FeePayment::create([
            'fee_assignment_id' => $this->paymentAssignmentId,
            'amount_paid' => $this->paymentAmountPaid,
            'payment_date' => $this->paymentDate,
            'payment_method' => $this->paymentMethod,
            'reference_number' => $this->paymentReferenceNumber,
            'remarks' => $this->paymentRemarks,
            'recorded_by' => auth()->id(),
        ]);

        // Status recalculation happens automatically via FeePayment's
        // "created" model event — nothing to do here.

        $this->lastReceiptId = $payment->id;

        $this->dispatch('notify', message: "Payment recorded — Receipt {$payment->receipt_number}.", type: 'success');
    }

    /*
    |--------------------------------------------------------------------------
    | Payment History — read-only, per enrollment. Edit/Delete on
    | individual assignments live here too, since a single enrollment can
    | have several fee assignments.
    |--------------------------------------------------------------------------
    */

    public bool $showHistoryModal = false;
    public $historyEnrollmentId;
    public $historyStudentName;

    public function openHistoryModal(int $enrollmentId)
    {
        if (! auth()->user()->can('view fee details')) {
            abort(403);
        }

        $enrollment = Enrollment::with('student')->findOrFail($enrollmentId);

        $this->historyEnrollmentId = $enrollment->id;
        $this->historyStudentName = $enrollment->student->name;
        $this->showHistoryModal = true;
    }

    public function closeHistoryModal()
    {
        $this->showHistoryModal = false;
    }

    public function getHistoryAssignmentsProperty()
    {
        if (! $this->showHistoryModal || ! $this->historyEnrollmentId) {
            return collect();
        }

        return FeeAssignment::where('enrollment_id', $this->historyEnrollmentId)
            ->with(['feeCategory', 'payments' => fn($q) => $q->orderByDesc('payment_date')])
            ->orderByDesc('due_date')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Assignment — only unlocked fields once a payment exists
    | (amount/category become read-only to protect the audit trail).
    | No academic year field here — that's implied by the enrollment's
    | cohort, which can't change after the fact.
    |--------------------------------------------------------------------------
    */

    public bool $showEditAssignmentModal = false;
    public $editAssignmentId;
    public $editAssignmentLocked = false;
    public $editFeeCategoryId = '';
    public $editInstallmentNumber = '';
    public $editAmount = '';
    public $editDueDate = '';
    public $editRemarks = '';

    public function openEditAssignmentModal(int $assignmentId)
    {
        if (! auth()->user()->can('edit fees')) {
            abort(403);
        }

        $assignment = FeeAssignment::findOrFail($assignmentId);

        $this->editAssignmentId = $assignment->id;
        $this->editAssignmentLocked = $assignment->isLockedForEditing();
        $this->editFeeCategoryId = $assignment->fee_category_id;
        $this->editInstallmentNumber = $assignment->installment_number;
        $this->editAmount = $assignment->amount;
        $this->editDueDate = $assignment->due_date->format('Y-m-d');
        $this->editRemarks = $assignment->remarks;
        $this->showEditAssignmentModal = true;
    }

    public function closeEditAssignmentModal()
    {
        $this->showEditAssignmentModal = false;
        $this->resetErrorBag();
    }

    public function updateAssignment()
    {
        if (! auth()->user()->can('edit fees')) {
            abort(403);
        }

        $assignment = FeeAssignment::findOrFail($this->editAssignmentId);

        if ($assignment->isLockedForEditing()) {
            // Only due_date/remarks are editable once a payment exists.
            $this->validate([
                'editDueDate' => 'required|date',
                'editRemarks' => 'nullable|string',
            ]);

            $assignment->update([
                'due_date' => $this->editDueDate,
                'remarks' => $this->editRemarks,
            ]);
        } else {
            $this->validate([
                'editFeeCategoryId' => 'required|exists:fee_categories,id',
                'editInstallmentNumber' => 'nullable|string|max:255',
                'editAmount' => 'required|numeric|min:0.01',
                'editDueDate' => 'required|date',
                'editRemarks' => 'nullable|string',
            ]);

            $assignment->update([
                'fee_category_id' => $this->editFeeCategoryId,
                'installment_number' => $this->editInstallmentNumber ?: null,
                'amount' => $this->editAmount,
                'due_date' => $this->editDueDate,
                'remarks' => $this->editRemarks,
            ]);
        }

        $assignment->recalculateStatus();

        $this->showEditAssignmentModal = false;

        $this->dispatch('notify', message: 'Fee assignment updated.', type: 'success');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Assignment — only if it has zero payments.
    |--------------------------------------------------------------------------
    */

    public $deleteAssignmentId;
    public bool $showDeleteAssignmentModal = false;

    public function confirmDeleteAssignment(int $assignmentId)
    {
        if (! auth()->user()->can('delete fees')) {
            abort(403);
        }

        $assignment = FeeAssignment::findOrFail($assignmentId);

        if (! $assignment->canBeDeleted()) {
            $this->dispatch('notify', message: 'Cannot delete — this assignment already has payments recorded against it.', type: 'error');
            return;
        }

        $this->deleteAssignmentId = $assignmentId;
        $this->showDeleteAssignmentModal = true;
    }

    public function deleteAssignment()
    {
        if (! auth()->user()->can('delete fees')) {
            abort(403);
        }

        $assignment = FeeAssignment::findOrFail($this->deleteAssignmentId);

        if (! $assignment->canBeDeleted()) {
            $this->dispatch('notify', message: 'Cannot delete — payments exist against this assignment.', type: 'error');
            $this->showDeleteAssignmentModal = false;
            return;
        }

        $assignment->delete();

        $this->showDeleteAssignmentModal = false;

        $this->dispatch('notify', message: 'Fee assignment deleted.', type: 'success');
    }

    public function closeDeleteAssignmentModal()
    {
        $this->showDeleteAssignmentModal = false;
        $this->deleteAssignmentId = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Render — one row per Enrollment, scoped to the active category tab. 
    |--------------------------------------------------------------------------
    */
    public function render()
    {
        $cohorts = Cohort::query()
            ->withCount('enrollments')
            ->ordered()
            ->get();

        $courses = Course::query()
            ->withCount('enrollments')
            ->orderBy('title')
            ->get();

        $categories = FeeCategory::active()
            ->orderBy('sort_order')
            ->get();

        // Shared filtered scope — used by BOTH the stat cards and the table below
        $baseQuery = Enrollment::query()
            ->when($this->cohortFilter, fn($query) => $query->where('cohort_id', $this->cohortFilter))
            ->when($this->courseFilter, fn($query) => $query->where('course_id', $this->courseFilter))
            ->when($this->search, function ($query) {
                $query->whereHas('student', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%");
                });
            });

        if ($this->categoryFilter !== 'all') {
            $baseQuery->whereHas('feeAssignments', function ($query) {
                $query->where('fee_category_id', $this->categoryFilter);
            });
        }

        /*
    |----------------------------------------------------------------
    | Stat cards — computed from the same filtered scope, no pagination
    |----------------------------------------------------------------
    */
        $statsEnrollmentIds = (clone $baseQuery)->pluck('id');

        $totalStudents = (clone $baseQuery)->distinct('student_id')->count('student_id');

        $assignmentQuery = FeeAssignment::whereIn('enrollment_id', $statsEnrollmentIds)
            ->when($this->categoryFilter !== 'all', fn($q) => $q->where('fee_category_id', $this->categoryFilter));

        $feesAssigned = (clone $assignmentQuery)->sum('amount');
        $assignmentIds = (clone $assignmentQuery)->pluck('id');

        $feesCollected = FeePayment::whereIn('fee_assignment_id', $assignmentIds)
            ->sum('amount_paid');

        $totalPaid = (clone $assignmentQuery)->where('status', 'paid')->count();

        $outstandingBalance = $feesAssigned - $feesCollected;

        /*
    |----------------------------------------------------------------
    | Table — same as before, just built off $baseQuery
    |----------------------------------------------------------------
    */
        $enrollments = (clone $baseQuery)
            ->with(['student.user', 'course', 'cohort'])
            ->with(['feeAssignments' => function ($query) {
                if ($this->categoryFilter !== 'all') {
                    $query->where('fee_category_id', $this->categoryFilter);
                }
                $query->with(['feeCategory', 'payments']);
            }])
            ->orderBy(
                Student::select('name')->whereColumn('students.id', 'enrollments.student_id')
            )
            ->paginate(10);

        return view('livewire.admin.fees.index', [
            'enrollments' => $enrollments,
            'categories' => $categories,
            'cohorts' => $cohorts,
            'courses' => $courses,
            'totalStudents' => $totalStudents,
            'feesAssigned' => $feesAssigned,
            'feesCollected' => $feesCollected,
            'outstandingBalance' => $outstandingBalance,
            'totalPaid' => $totalPaid,
            'canManage' => auth()->user()->can('manage fees'),
            'canEdit' => auth()->user()->can('edit fees'),
            'canDelete' => auth()->user()->can('delete fees'),
            'canView' => auth()->user()->can('view fee details'),
        ]);
    }
}
