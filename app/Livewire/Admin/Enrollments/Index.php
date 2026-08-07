<?php

namespace App\Livewire\Admin\Enrollments;

use App\Models\Enrollment;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'tailwind';

    /*
    |--------------------------------------------------------------------------
    | UI State
    |--------------------------------------------------------------------------
    */

    public string $status = 'enrolled';

    public string $search = '';

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Mark In Training — enrolled -> in_training. Single confirm step
    | (wire:confirm in the view), no reason needed.
    |--------------------------------------------------------------------------
    */

    public function markInTraining(int $enrollmentId)
    {
        if (! auth()->user()->can('manage enrollments')) {
            abort(403);
        }

        $enrollment = Enrollment::findOrFail($enrollmentId);

        if ($enrollment->status !== 'enrolled') {
            $this->dispatch('notify', message: 'Only enrolled students can be moved to in-training.', type: 'error');
            return;
        }

        $enrollment->markInTraining();

        $this->dispatch('notify', message: 'Enrollment moved to In Training.', type: 'success');
    }

    /*
    |--------------------------------------------------------------------------
    | Complete — in_training -> completed. Single confirm step.
    |--------------------------------------------------------------------------
    */

    public function complete(int $enrollmentId)
    {
        if (! auth()->user()->can('manage enrollments')) {
            abort(403);
        }

        $enrollment = Enrollment::findOrFail($enrollmentId);

        if ($enrollment->status !== 'in_training') {
            $this->dispatch('notify', message: 'Only in-training enrollments can be completed.', type: 'error');
            return;
        }

        $enrollment->complete();

        $this->dispatch('notify', message: 'Enrollment marked as completed.', type: 'success');
    }

    /*
    |--------------------------------------------------------------------------
    | Withdraw — requires a reason, so this uses a confirmation modal
    | (same pattern as Application reject / Student delete elsewhere).
    | Allowed from enrolled or in_training, per the status diagram.
    |--------------------------------------------------------------------------
    */

    public $showWithdrawModal = false;
    public $withdrawEnrollmentId;
    public $withdrawReason = '';

    public function confirmWithdraw(int $enrollmentId)
    {
        if (! auth()->user()->can('manage enrollments')) {
            abort(403);
        }

        $enrollment = Enrollment::findOrFail($enrollmentId);

        if (! in_array($enrollment->status, ['enrolled', 'in_training'])) {
            $this->dispatch('notify', message: 'Only enrolled or in-training enrollments can be withdrawn.', type: 'error');
            return;
        }

        $this->withdrawEnrollmentId = $enrollmentId;
        $this->withdrawReason = '';
        $this->showWithdrawModal = true;
    }

    public function withdrawEnrollment()
    {
        $this->validate([
            'withdrawReason' => 'required|string|min:3',
        ]);

        $enrollment = Enrollment::findOrFail($this->withdrawEnrollmentId);
        $enrollment->withdraw($this->withdrawReason);

        $this->showWithdrawModal = false;
        $this->withdrawEnrollmentId = null;
        $this->withdrawReason = '';

        $this->dispatch('notify', message: 'Enrollment withdrawn.', type: 'success');
    }

    public function closeWithdrawModal()
    {
        $this->showWithdrawModal = false;
        $this->withdrawEnrollmentId = null;
        $this->withdrawReason = '';
    }

    /*
    |--------------------------------------------------------------------------
    | Suspend — any active state (enrolled/in_training) -> suspended.
    | Single confirm step, no reason required.
    |--------------------------------------------------------------------------
    */

    public function suspend(int $enrollmentId)
    {
        if (! auth()->user()->can('manage enrollments')) {
            abort(403);
        }

        $enrollment = Enrollment::findOrFail($enrollmentId);

        if (! in_array($enrollment->status, ['enrolled', 'in_training'])) {
            $this->dispatch('notify', message: 'Only enrolled or in-training enrollments can be suspended.', type: 'error');
            return;
        }

        $enrollment->suspend();

        $this->dispatch('notify', message: 'Enrollment suspended.', type: 'success');
    }

    /*
    |--------------------------------------------------------------------------
    | Reactivate — suspended -> (enrolled|in_training). There's no stored
    | "previous status" column, so the admin picks the target state in a
    | small modal.
    |--------------------------------------------------------------------------
    */

    public $showReactivateModal = false;
    public $reactivateEnrollmentId;
    public $reactivateTargetStatus = 'enrolled';

    public function confirmReactivate(int $enrollmentId)
    {
        if (! auth()->user()->can('manage enrollments')) {
            abort(403);
        }

        $enrollment = Enrollment::findOrFail($enrollmentId);

        if ($enrollment->status !== 'suspended') {
            $this->dispatch('notify', message: 'Only suspended enrollments can be reactivated.', type: 'error');
            return;
        }

        $this->reactivateEnrollmentId = $enrollmentId;
        $this->reactivateTargetStatus = 'enrolled';
        $this->showReactivateModal = true;
    }

    public function reactivateEnrollment()
    {
        $this->validate([
            'reactivateTargetStatus' => 'required|in:enrolled,in_training',
        ]);

        $enrollment = Enrollment::findOrFail($this->reactivateEnrollmentId);
        $enrollment->reactivate($this->reactivateTargetStatus);

        $this->showReactivateModal = false;
        $this->reactivateEnrollmentId = null;

        $this->dispatch('notify', message: 'Enrollment reactivated.', type: 'success');
    }

    public function closeReactivateModal()
    {
        $this->showReactivateModal = false;
        $this->reactivateEnrollmentId = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Progress update — allowed while enrolled or in_training.
    |--------------------------------------------------------------------------
    */

    public $showProgressModal = false;
    public $progressEnrollmentId;
    public $progressValue = 0;

    public function confirmProgress(int $enrollmentId)
    {
        if (! auth()->user()->can('manage enrollments')) {
            abort(403);
        }

        $enrollment = Enrollment::findOrFail($enrollmentId);

        $this->progressEnrollmentId = $enrollmentId;
        $this->progressValue = $enrollment->progress_percentage ?? 0;
        $this->showProgressModal = true;
    }

    public function saveProgress()
    {
        $this->validate([
            'progressValue' => 'required|integer|min:0|max:100',
        ]);

        $enrollment = Enrollment::findOrFail($this->progressEnrollmentId);
        $enrollment->updateProgress((int) $this->progressValue);

        $this->showProgressModal = false;
        $this->progressEnrollmentId = null;

        $this->dispatch('notify', message: 'Progress updated.', type: 'success');
    }

    public function closeProgressModal()
    {
        $this->showProgressModal = false;
        $this->progressEnrollmentId = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Certificate issuance — only allowed once completed (Business Rule #6).
    |--------------------------------------------------------------------------
    */

    public $showCertificateModal = false;
    public $certificateEnrollmentId;
    public $certificateFile;

    public function confirmIssueCertificate(int $enrollmentId)
    {
        if (! auth()->user()->can('manage enrollments')) {
            abort(403);
        }

        $enrollment = Enrollment::findOrFail($enrollmentId);

        if ($enrollment->status !== 'completed') {
            $this->dispatch('notify', message: 'Certificates can only be issued for completed enrollments.', type: 'error');
            return;
        }

        $this->certificateEnrollmentId = $enrollmentId;
        $this->certificateFile = null;
        $this->showCertificateModal = true;
    }

    public function issueCertificate()
    {
        $this->validate([
            'certificateFile' => 'required|mimes:pdf|max:4096',
        ]);

        $path = $this->certificateFile->store('certificates', 'public');

        $enrollment = Enrollment::findOrFail($this->certificateEnrollmentId);
        $enrollment->issueCertificate($path);

        $this->showCertificateModal = false;
        $this->certificateEnrollmentId = null;
        $this->certificateFile = null;

        $this->dispatch('notify', message: 'Certificate issued.', type: 'success');
    }

    public function closeCertificateModal()
    {
        $this->showCertificateModal = false;
        $this->certificateEnrollmentId = null;
        $this->certificateFile = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $statusCounts = Enrollment::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $enrollments = Enrollment::query()
            ->with(['student.user', 'course', 'cohort'])
            ->where('status', $this->status)
            ->when($this->search, function ($query) {
                $query->whereHas('student', function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($query) {
                            $query->where('registration_id', 'like', "%{$this->search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.enrollments.index', [
            'enrollments' => $enrollments,
            'statusCounts' => $statusCounts,
            'canManage' => auth()->user()->can('manage enrollments'),
        ]);
    }
}
