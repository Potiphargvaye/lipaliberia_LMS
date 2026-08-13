<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\FeeAssignment;
use App\Models\Student;
use Illuminate\View\View;

class StudentFeesController extends Controller
{
    /**
     * Student's own fee status — a read-only mirror of the admin fees
     * module. Reuses FeeAssignment::balance() and status rather than
     * re-deriving the numbers, so this can never drift from the admin
     * side's figures.
     */
    public function index(): View
    {
        $student = Student::with('user')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $activeEnrollment = $student->activeEnrollment();

        $assignments = FeeAssignment::whereHas('enrollment', function ($query) use ($student) {
            $query->where('student_id', $student->id);
        })
            ->with(['feeCategory', 'payments', 'enrollment.course', 'enrollment.cohort'])
            ->orderByDesc('due_date')
            ->get();

        $totalAssigned = $assignments->sum('amount');
        $totalPaid = $assignments->sum(fn($a) => $a->payments->sum('amount_paid'));
        $balance = $totalAssigned - $totalPaid;

        if ($assignments->isEmpty()) {
            $overallStatus = 'no_fees';
        } elseif ($balance <= 0) {
            $overallStatus = 'paid';
        } elseif ($totalPaid > 0) {
            $overallStatus = 'partial';
        } else {
            $overallStatus = 'pending';
        }

        $percentPaid = $totalAssigned > 0
            ? min(100, round(($totalPaid / $totalAssigned) * 100))
            : 0;

        $payments = $assignments->flatMap->payments->sortByDesc('payment_date')->values();

        return view('student.fees.index', compact(
            'student',
            'activeEnrollment',
            'assignments',
            'payments',
            'totalAssigned',
            'totalPaid',
            'balance',
            'overallStatus',
            'percentPaid'
        ));
    }
}
