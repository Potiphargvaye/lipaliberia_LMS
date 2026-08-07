<?php

namespace App\Livewire\Admin\Applications;

use App\Models\Application;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    /*
    |--------------------------------------------------------------------------
    | UI State
    |--------------------------------------------------------------------------
    */

    public string $status = 'pending';

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
    | Approve — single confirm step (wire:confirm in the view), no reason
    | needed, so no modal required here.
    |--------------------------------------------------------------------------
    */

    public function approve(int $applicationId)
    {
        if (! auth()->user()->can('approve applications')) {
            abort(403);
        }

        $application = Application::findOrFail($applicationId);

        if ($application->status !== 'pending') {
            $this->dispatch('notify', message: 'Only pending applications can be approved.', type: 'error');
            return;
        }

        $application->approve(auth()->user());

        $this->dispatch('notify', message: 'Application approved and student enrolled.', type: 'success');
    }

    /*
    |--------------------------------------------------------------------------
    | Reject — requires a reason, so this uses a confirmation modal
    | (same pattern as the delete/withdraw modals elsewhere in the app).
    |--------------------------------------------------------------------------
    */

    public $showRejectModal = false;

    public $rejectApplicationId;

    public $rejectReason = '';

    public function confirmReject(int $applicationId)
    {
        if (! auth()->user()->can('approve applications')) {
            abort(403);
        }

        $this->rejectApplicationId = $applicationId;
        $this->rejectReason = '';
        $this->showRejectModal = true;
    }

    public function rejectApplication()
    {
        $this->validate([
            'rejectReason' => 'required|string|min:3',
        ]);

        $application = Application::findOrFail($this->rejectApplicationId);

        $application->reject(auth()->user(), $this->rejectReason);

        $this->showRejectModal = false;
        $this->rejectApplicationId = null;
        $this->rejectReason = '';

        $this->dispatch('notify', message: 'Application rejected.', type: 'success');
    }

    public function closeRejectModal()
    {
        $this->showRejectModal = false;
        $this->rejectApplicationId = null;
        $this->rejectReason = '';
    }

    /*
    |--------------------------------------------------------------------------
    | Cancel — per the status diagram, pending/approved applications can be
    | cancelled (student or admin initiated). Simple direct action.
    |--------------------------------------------------------------------------
    */

    public function cancel(int $applicationId)
    {
        if (! auth()->user()->can('approve applications')) {
            abort(403);
        }

        $application = Application::findOrFail($applicationId);

        if (! in_array($application->status, ['pending', 'approved'])) {
            $this->dispatch('notify', message: 'Only pending or approved applications can be cancelled.', type: 'error');
            return;
        }

        $application->update(['status' => 'cancelled']);

        $this->dispatch('notify', message: 'Application cancelled.', type: 'success');
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $statusCounts = Application::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $applications = Application::query()
            ->with(['student.user', 'course', 'cohort'])
            ->where('status', $this->status)
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('application_number', 'like', "%{$this->search}%")
                        ->orWhereHas('student', function ($query) {
                            $query->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.applications.index', [
            'applications' => $applications,
            'statusCounts' => $statusCounts,
            'canApprove' => auth()->user()->can('approve applications'),
        ]);
    }
}
