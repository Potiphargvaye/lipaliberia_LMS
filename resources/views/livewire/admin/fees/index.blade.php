<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Fees Management</h1>
            <p class="text-gray-500 text-sm mt-1">
                One record per student — assign fees, record payments, and view history from their row.
            </p>
        </div>

        <a href="{{ route('admin.fee-categories.index') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-md border border-[#155E8A] text-[#155E8A] font-semibold text-sm hover:bg-sky-50 transition-colors">
            <i class="fas fa-tags text-xs"></i>
            Manage Categories
        </a>
    </div>

    {{-- Stat Cards (static placeholder figures — no calculation logic) --}}
    <div class="grid grid-cols-2 xs:grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">

        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0">
            <div class="h-10 w-10 rounded-lg bg-[#155E8A]/10 text-[#155E8A] flex items-center justify-center shrink-0">
                <i class="fas fa-users text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Total Students</p>
                <p class="text-base sm:text-lg font-bold text-slate-800 truncate">248</p>
            </div>
        </div>

        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0">
            <div class="h-10 w-10 rounded-lg bg-[#155E8A]/10 text-[#155E8A] flex items-center justify-center shrink-0">
                <i class="fas fa-file-invoice-dollar text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Fees Assigned</p>
                <p class="text-base sm:text-lg font-bold text-slate-800 truncate">$142,500. LRD</p>
            </div>
        </div>

        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0">
            <div class="h-10 w-10 rounded-lg bg-green-100 text-green-700 flex items-center justify-center shrink-0">
                <i class="fas fa-circle-check text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Fees Collected</p>
                <p class="text-base sm:text-lg font-bold text-green-700 truncate">$300.00 LRD</p>
            </div>
        </div>

        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0">
            <div class="h-10 w-10 rounded-lg bg-[#B91C1C]/10 text-[#B91C1C] flex items-center justify-center shrink-0">
                <i class="fas fa-scale-unbalanced text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Outstanding Balance</p>
                <p class="text-base sm:text-lg font-bold text-[#B91C1C] truncate">$44,200.00</p>
            </div>
        </div>

        <div
            class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0 col-span-2 sm:col-span-1">
            <div class="h-10 w-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                <i class="fas fa-money-bill-wave text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Total Paid</p>
                <p class="text-base sm:text-lg font-bold text-slate-800 truncate">$98,300.LRD</p>
            </div>
        </div>

    </div>

    {{-- Category Tabs --}}
    <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-3">
        <button type="button" wire:click="$set('categoryFilter', 'all')"
            class="px-4 py-2 rounded-md text-sm font-semibold transition-colors
                {{ $categoryFilter === 'all' ? 'bg-[#155E8A] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            All Fees
        </button>
        @foreach ($categories as $category)
            <button type="button" wire:click="$set('categoryFilter', '{{ $category->id }}')"
                class="px-4 py-2 rounded-md text-sm font-semibold transition-colors
                    {{ (string) $categoryFilter === (string) $category->id ? 'bg-[#155E8A] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ $category->name }}
            </button>
        @endforeach
    </div>

    <div class="w-full sm:w-64">
        <select wire:model.live="cohortFilter"
            class="w-full rounded-lg border-gray-300 text-sm focus:ring-[#155E8A] focus:border-[#155E8A]">

            <option value="">All Cohorts</option>

            @foreach ($cohorts as $cohort)
                <option value="{{ $cohort->id }}">
                    {{ $cohort->name }} ({{ $cohort->enrollments_count }})
                </option>
            @endforeach

        </select>
    </div>

    {{-- Search + Grade Filter --}}
    <div class="bg-gray-50 border border-gray-200 rounded-md p-3 sm:p-4 flex flex-col sm:flex-row gap-2 sm:gap-3">
        <div class="relative flex-1">
            <i class="fas fa-magnifying-glass text-gray-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input type="text" wire:model.live.debounce.350ms="search"
                placeholder="Search by student name or Student ID..."
                class="w-full pl-10 pr-3 py-2.5 rounded-md border border-gray-300 text-sm text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
        </div>

        <select wire:model.live="courseFilter"
            class="py-2.5 px-3 border border-gray-300 rounded-md text-sm bg-white min-w-[160px] focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">

            <option value="">All Courses</option>

            @foreach ($courses as $course)
                <option value="{{ $course->id }}">
                    {{ $course->title }} ({{ $course->enrollments_count }})
                </option>
            @endforeach

        </select>
    </div>

    {{-- Students Table --}}
    <div class="bg-white rounded-md border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-sm">
                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Course</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Cohort</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide">Assigned</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide">Paid</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide">Balance</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($enrollments as $enrollment)
                        @php
                            $totalAssigned = $enrollment->feeAssignments->sum('amount');
                            $totalPaid = $enrollment->feeAssignments->sum(fn($a) => $a->payments->sum('amount_paid'));
                            $balance = $totalAssigned - $totalPaid; // ← this line is what's missing

if ($enrollment->feeAssignments->isEmpty()) {
    $rowStatus = 'no_fees';
} elseif ($balance <= 0) {
    $rowStatus = 'paid';
} elseif ($enrollment->feeAssignments->contains('status', 'overdue')) {
    $rowStatus = 'overdue';
} elseif ($totalPaid > 0) {
    $rowStatus = 'partial';
} else {
    $rowStatus = 'pending';
}

$statusClasses = [
    'no_fees' => 'bg-gray-100 text-gray-500',
    'pending' => 'bg-yellow-100 text-yellow-800',
    'partial' => 'bg-blue-100 text-blue-800',
    'paid' => 'bg-green-100 text-green-800',
    'overdue' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <tr wire:key="enrollment-{{ $enrollment->id }}" class="hover:bg-[#155E8A]/5 transition-colors">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-800">{{ $enrollment->student->name }}</div>

                                <div class="text-xs text-gray-400 font-mono">
                                    {{ $enrollment->student->user?->registration_id ?? '—' }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $enrollment->course->title ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $enrollment->cohort->name }}</td>
                            <td class="px-4 py-3 text-right text-gray-700">${{ number_format($totalAssigned, 2) }}</td>
                            <td class="px-4 py-3 text-right text-green-600 font-semibold">
                                ${{ number_format($totalPaid, 2) }}</td>
                            <td class="px-4 py-3 text-right text-[#B91C1C] font-semibold">
                                ${{ number_format($balance, 2) }}</td>
                            <td class="px-4 py-3 text-center">
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses[$rowStatus] }}">
                                    {{ $rowStatus === 'no_fees' ? 'No Fees' : ucfirst($rowStatus) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap justify-center gap-1.5">
                                    @if ($canManage)
                                        <button wire:click="openAssignModal({{ $enrollment->id }})"
                                            class="px-2.5 py-1.5 rounded-md bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] text-xs font-semibold transition-colors"
                                            title="Assign Fee">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                        <button wire:click="openPaymentModal({{ $enrollment->id }})"
                                            class="px-2.5 py-1.5 rounded-md bg-green-100 hover:bg-green-700 hover:text-white text-green-700 text-xs font-semibold transition-colors"
                                            title="Record Payment">
                                            <i class="fas fa-money-bill-wave text-xs"></i>
                                        </button>
                                    @endif

                                    @if ($canView)
                                        <button wire:click="openHistoryModal({{ $enrollment->id }})"
                                            class="px-2.5 py-1.5 rounded-md bg-gray-100 hover:bg-gray-700 hover:text-white text-gray-600 text-xs font-semibold transition-colors"
                                            title="Payment History">
                                            <i class="fas fa-clock-rotate-left text-xs"></i>
                                        </button>
                                        <a href="{{ route('admin.fees.statement', $enrollment->student_id) }}"
                                            target="_blank"
                                            class="px-2.5 py-1.5 rounded-md bg-[#B91C1C]/10 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] text-xs font-semibold transition-colors"
                                            title="Fee Statement">
                                            <i class="fas fa-file-invoice text-xs"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-16">
                                <i class="fas fa-users text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 text-sm">No students found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-gray-50 px-4 sm:px-6 py-4 border-t border-gray-200">
            {{ $enrollments->links() }}
        </div>
    </div>

    {{-- Assign Fee Modal --}}
    @if ($showAssignModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">

            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden">

                <!-- Header -->
                <div class="relative bg-[#155E8A] px-6 py-5 shrink-0">

                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#B91C1C]"></div>

                    <div class="flex items-start justify-between gap-3">

                        <div class="flex items-center gap-3">

                            <div
                                class="h-11 w-11 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5">

                                <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}"
                                    alt="LIPA Logo" class="h-full w-full object-contain">

                            </div>

                            <div>

                                <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold">
                                    Liberia Institute of Public Administration
                                </p>

                                <h2 class="text-white text-lg font-bold">
                                    Assign Student Fee
                                </h2>

                                <p class="text-sky-100 text-sm mt-1">
                                    {{ $assignStudentName }}
                                </p>

                            </div>

                        </div>

                        <button wire:click="closeAssignModal"
                            class="h-10 w-10 rounded-lg bg-white/10 hover:bg-red-600 transition flex items-center justify-center text-white">

                            <i class="fas fa-times"></i>

                        </button>

                    </div>

                </div>

                <!-- Body -->
                <form wire:submit.prevent="saveAssignment" class="flex-1 overflow-y-auto bg-[#F8FAFC] p-6 space-y-6">

                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-5">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                            <!-- Fee Category -->
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Fee Category
                                </label>

                                <select wire:model="assignFeeCategoryId"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                    <option value="">Select Category</option>

                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('assignFeeCategoryId')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            <!-- Cohort -->
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Cohort
                                </label>

                                <select wire:model="assignCohort"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                    <option value="">
                                        Select Cohort
                                    </option>

                                    @foreach (\App\Models\Cohort::where('is_active', true)->ordered()->get() as $cohort)
                                        <option value="{{ $cohort->id }}">
                                            {{ $cohort->name }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('assignAcademicYear')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-5">

                            <!-- Installment -->
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Installment
                                    <span class="text-slate-400 font-normal">
                                        (Optional)
                                    </span>
                                </label>

                                <input type="text" wire:model="assignInstallmentNumber"
                                    placeholder="e.g. 1st Installment"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                            </div>

                            <!-- Amount -->
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Amount
                                </label>

                                <input type="number" step="0.01" wire:model="assignAmount"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('assignAmount')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                        <!-- Due Date -->
                        <div class="mt-5">

                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Due Date
                            </label>

                            <input type="date" wire:model="assignDueDate"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                            @error('assignDueDate')
                                <p class="mt-1 text-xs text-[#B91C1C] font-medium">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <!-- Remarks -->
                        <div class="mt-5">

                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Remarks / Reason

                                <span class="text-slate-400 font-normal">
                                    (Optional)
                                </span>

                            </label>

                            <textarea wire:model="assignRemarks" rows="3"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>

                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="bg-white border border-[#E2E8F0] rounded-xl px-5 py-4 flex justify-end gap-3">

                        <button type="button" wire:click="closeAssignModal"
                            class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">

                            Cancel

                        </button>

                        <button type="submit" wire:loading.attr="disabled" wire:target="saveAssignment"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4C81] disabled:opacity-60 disabled:cursor-not-allowed text-white text-sm font-semibold transition">

                            <span wire:loading.remove wire:target="saveAssignment">
                                <i class="fas fa-save"></i>
                                Assign Fee
                            </span>

                            <span wire:loading wire:target="saveAssignment">
                                <i class="fas fa-spinner fa-spin"></i>
                                Assigning...
                            </span>

                        </button>

                    </div>

                </form>

            </div>

        </div>
    @endif

    {{-- Record Payment Modal --}}
    @if ($showPaymentModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">

            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden">

                <!-- Header -->
                <div class="relative bg-[#155E8A] px-6 py-5 shrink-0">

                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#B91C1C]"></div>

                    <div class="flex items-start justify-between gap-3">

                        <div class="flex items-center gap-3">

                            <div
                                class="h-11 w-11 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5">

                                <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}"
                                    alt="LIPA Logo" class="h-full w-full object-contain">

                            </div>

                            <div>

                                <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold">
                                    Liberia Institute of Public Administration
                                </p>

                                <h2 class="text-white text-lg font-bold">
                                    Record Payment
                                </h2>

                                <p class="text-sky-100 text-sm mt-1">
                                    {{ $paymentStudentName }}
                                </p>

                            </div>

                        </div>

                        <button wire:click="closePaymentModal"
                            class="h-10 w-10 rounded-lg bg-white/10 hover:bg-red-600 transition flex items-center justify-center text-white">

                            <i class="fas fa-times"></i>

                        </button>

                    </div>

                </div>

                @if ($lastReceiptId)
                    {{-- Receipt-ready state --}}
                    <div class="p-6 text-center space-y-4">
                        <i class="fas fa-circle-check text-5xl text-green-500"></i>
                        <p class="text-slate-700 font-semibold">Payment recorded successfully.</p>
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.fees.receipts.show', $lastReceiptId) }}" target="_blank"
                                class="px-4 py-2 text-sm rounded-md bg-[#155E8A] text-white font-semibold hover:bg-[#0F4C81]">
                                <i class="fas fa-receipt text-xs mr-1"></i> View / Print Receipt
                            </a>
                            <a href="{{ route('admin.fees.receipts.download', $lastReceiptId) }}"
                                class="px-4 py-2 text-sm rounded-md border border-slate-300 text-slate-700 hover:bg-slate-100">
                                <i class="fas fa-download text-xs mr-1"></i> PDF
                            </a>
                        </div>
                        <button wire:click="closePaymentModal"
                            class="text-sm text-slate-500 hover:underline">Done</button>
                    </div>
                @else
                    <!-- Body -->
                    <form wire:submit.prevent="savePayment" class="flex-1 overflow-y-auto bg-[#F8FAFC] p-6 space-y-6">

                        <div class="bg-white rounded-xl border border-[#E2E8F0] p-5">

                            <!-- Fee Assignment -->
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Fee Assignment
                                </label>

                                <select wire:model.live="paymentAssignmentId"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                    <option value="">
                                        Select outstanding fee...
                                    </option>

                                    @foreach ($paymentOutstandingAssignments as $assignment)
                                        <option value="{{ $assignment->id }}">
                                            {{ $assignment->feeCategory->name }} — {{ $assignment->academic_year }}
                                            (Balance: ${{ number_format($assignment->balance(), 2) }})
                                        </option>
                                    @endforeach

                                </select>

                                @error('paymentAssignmentId')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            @if ($this->selectedAssignment)
                                <div
                                    class="mt-4 bg-sky-50 border border-sky-100 rounded-lg p-3.5 text-xs text-[#155E8A] grid grid-cols-2 gap-2">

                                    <div>
                                        <span class="font-semibold">Academic Year:</span>
                                        {{ $this->selectedAssignment->academic_year }}
                                    </div>

                                    <div>
                                        <span class="font-semibold">Outstanding Balance:</span>
                                        ${{ number_format($this->selectedAssignment->balance(), 2) }}
                                    </div>

                                </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-5">

                                <!-- Amount Paid -->
                                <div>

                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                        Amount Paid
                                    </label>

                                    <input type="number" step="0.01" wire:model="paymentAmountPaid"
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                    @error('paymentAmountPaid')
                                        <p class="mt-1 text-xs text-[#B91C1C] font-medium">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                                <!-- Payment Date -->
                                <div>

                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                        Payment Date
                                    </label>

                                    <input type="date" wire:model="paymentDate"
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                    @error('paymentDate')
                                        <p class="mt-1 text-xs text-[#B91C1C] font-medium">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-5">

                                <!-- Payment Method -->
                                <div>

                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                        Payment Method
                                    </label>

                                    <select wire:model="paymentMethod"
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                        <option value="">Select Method</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Check">Check</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Mobile Money">Mobile Money</option>

                                    </select>

                                    @error('paymentMethod')
                                        <p class="mt-1 text-xs text-[#B91C1C] font-medium">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                                <!-- Reference Number -->
                                <div>

                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                        Reference Number
                                        <span class="text-slate-400 font-normal">
                                            (Optional)
                                        </span>
                                    </label>

                                    <input type="text" wire:model="paymentReferenceNumber"
                                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                </div>

                            </div>

                            <!-- Remarks -->
                            <div class="mt-5">

                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Remarks / Reason
                                    <span class="text-[#B91C1C] font-semibold">
                                        (Required)
                                    </span>
                                </label>

                                <textarea wire:model="paymentRemarks" rows="3"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>

                                @error('paymentRemarks')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                        <!-- Footer -->
                        <div class="bg-white border border-[#E2E8F0] rounded-xl px-5 py-4 flex justify-end gap-3">

                            <button type="button" wire:click="closePaymentModal"
                                class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">

                                Cancel

                            </button>

                            <button type="submit" wire:loading.attr="disabled" wire:target="savePayment"
                                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-green-700 hover:bg-green-800 disabled:opacity-60 disabled:cursor-not-allowed text-white text-sm font-semibold transition">

                                <span wire:loading.remove wire:target="savePayment">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Record Payment
                                </span>

                                <span wire:loading wire:target="savePayment">
                                    <i class="fas fa-spinner fa-spin"></i>
                                    Recording...
                                </span>

                            </button>

                        </div>

                    </form>
                @endif

            </div>

        </div>
    @endif

    {{-- Payment History Modal (includes Edit/Delete per assignment) --}}
    @if ($showHistoryModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-3xl max-h-[92vh] flex flex-col overflow-hidden">

                <!-- Header -->
                <div class="relative bg-[#155E8A] px-6 py-5 shrink-0">

                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#B91C1C]"></div>

                    <div class="flex items-start justify-between gap-3">

                        <div class="flex items-center gap-3">

                            <div
                                class="h-11 w-11 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5">

                                <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}"
                                    alt="LIPA Logo" class="h-full w-full object-contain">

                            </div>

                            <div>

                                <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold">
                                    Liberia Institute of Public Administration
                                </p>

                                <h2 class="text-white text-lg font-bold">
                                    Fee History
                                </h2>

                                <p class="text-sky-100 text-sm mt-1">
                                    {{ $historyStudentName }}
                                </p>

                            </div>

                        </div>

                        <button wire:click="closeHistoryModal"
                            class="h-10 w-10 rounded-lg bg-white/10 hover:bg-red-600 transition flex items-center justify-center text-white">

                            <i class="fas fa-times"></i>

                        </button>

                    </div>

                </div>

                <!-- Body -->
                <div class="flex-1 overflow-y-auto bg-[#F8FAFC] p-6 space-y-4">

                    @forelse ($this->historyAssignments as $assignment)
                        <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">

                            <div
                                class="bg-[#F8FAFC] px-4 py-3 flex flex-wrap items-center justify-between gap-2 border-b border-[#E2E8F0]">

                                <div class="text-sm">
                                    <span class="font-semibold text-slate-800">
                                        {{ $assignment->feeCategory->name }}
                                    </span>
                                    <span class="text-slate-400">
                                        — {{ $assignment->academic_year }}
                                    </span>
                                    @if ($assignment->installment_number)
                                        <span class="text-slate-400">
                                            ({{ $assignment->installment_number }})
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">

                                    <span
                                        class="text-xs px-2.5 py-1 rounded-full font-medium
                                        @if ($assignment->status === 'paid') bg-green-100 text-green-700
                                        @elseif($assignment->status === 'overdue') bg-red-100 text-red-700
                                        @elseif($assignment->status === 'partial') bg-blue-100 text-blue-700
                                        @else bg-yellow-100 text-yellow-700 @endif">
                                        {{ ucfirst($assignment->status) }}
                                    </span>

                                    <span class="text-xs text-slate-500">
                                        ${{ number_format($assignment->amount, 2) }} due
                                        {{ $assignment->due_date->format('M d, Y') }}
                                    </span>

                                    @if ($canEdit)
                                        <button wire:click="openEditAssignmentModal({{ $assignment->id }})"
                                            class="h-8 w-8 rounded-md bg-yellow-100 hover:bg-yellow-500 hover:text-white text-yellow-700 flex items-center justify-center transition"
                                            title="Edit">
                                            <i class="fas fa-pen text-xs"></i>
                                        </button>
                                    @endif

                                    @if ($canDelete)
                                        <button wire:click="confirmDeleteAssignment({{ $assignment->id }})"
                                            class="h-8 w-8 rounded-md bg-[#B91C1C]/10 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] flex items-center justify-center transition"
                                            title="Delete">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    @endif

                                </div>

                            </div>

                            @if ($assignment->payments->isNotEmpty())
                                <table class="w-full text-xs">
                                    <thead class="bg-white text-slate-400 uppercase">
                                        <tr>
                                            <th class="px-4 py-2.5 text-left">Date</th>
                                            <th class="px-4 py-2.5 text-right">Amount</th>
                                            <th class="px-4 py-2.5 text-left">Method</th>
                                            <th class="px-4 py-2.5 text-left">Receipt #</th>
                                            <th class="px-4 py-2.5 text-left">Recorded By</th>
                                            <th class="px-4 py-2.5 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach ($assignment->payments as $payment)
                                            <tr class="hover:bg-[#155E8A]/5 transition">
                                                <td class="px-4 py-2.5 text-slate-600">
                                                    {{ $payment->payment_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-4 py-2.5 text-right font-semibold text-green-700">
                                                    ${{ number_format($payment->amount_paid, 2) }}
                                                </td>
                                                <td class="px-4 py-2.5 text-slate-600">
                                                    {{ $payment->payment_method }}
                                                </td>
                                                <td class="px-4 py-2.5 font-mono text-slate-600">
                                                    {{ $payment->receipt_number }}
                                                </td>
                                                <td class="px-4 py-2.5 text-slate-600">
                                                    {{ $payment->recordedBy?->name ?? '—' }}
                                                </td>
                                                <td class="px-4 py-2.5">
                                                    <div class="flex justify-center gap-1.5">
                                                        <a href="{{ route('admin.fees.receipts.show', $payment) }}"
                                                            target="_blank"
                                                            class="h-7 w-7 rounded-md bg-[#155E8A]/10 text-[#155E8A] hover:bg-[#155E8A] hover:text-white flex items-center justify-center transition"
                                                            title="View / Print">
                                                            <i class="fas fa-print text-[11px]"></i>
                                                        </a>
                                                        <a href="{{ route('admin.fees.receipts.download', $payment) }}"
                                                            class="h-7 w-7 rounded-md bg-[#B91C1C]/10 text-[#B91C1C] hover:bg-[#B91C1C] hover:text-white flex items-center justify-center transition"
                                                            title="Download PDF">
                                                            <i class="fas fa-file-pdf text-[11px]"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="px-4 py-6 text-center text-xs text-slate-400">
                                    No payments recorded yet.
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-400 text-sm">
                            <i class="fas fa-receipt text-4xl text-slate-300 mb-3 block"></i>
                            No fee assignments for this student yet.
                        </div>
                    @endforelse

                </div>

                <!-- Footer -->
                <div class="bg-white border-t border-[#E2E8F0] px-5 py-4 flex justify-end">
                    <button wire:click="closeHistoryModal"
                        class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4C81] text-white text-sm font-semibold transition">
                        Close
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- Edit Assignment Modal --}}
    @if ($showEditAssignmentModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-lg max-h-[92vh] flex flex-col overflow-hidden">

                <div class="relative bg-[#155E8A] px-6 py-5 shrink-0">

                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#B91C1C]"></div>

                    <div class="flex items-start justify-between gap-3">

                        <div class="flex items-center gap-3">

                            <div
                                class="h-11 w-11 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5">

                                <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}"
                                    alt="LIPA Logo" class="h-full w-full object-contain">

                            </div>

                            <h3 class="text-white text-lg font-bold">Edit Fee Assignment</h3>

                        </div>

                        <button wire:click="closeEditAssignmentModal"
                            class="h-10 w-10 rounded-lg bg-white/10 hover:bg-red-600 transition flex items-center justify-center text-white">
                            <i class="fas fa-times"></i>
                        </button>

                    </div>

                </div>

                <form wire:submit.prevent="updateAssignment"
                    class="flex-1 overflow-y-auto bg-[#F8FAFC] p-6 space-y-5">

                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-5 space-y-4">

                        @if ($editAssignmentLocked)
                            <div class="bg-amber-50 border border-amber-100 rounded-lg p-3 text-xs text-amber-800">
                                <i class="fas fa-lock text-[10px] mr-1"></i>
                                Payments already exist against this fee — only the due date and remarks can be changed,
                                to protect the payment audit trail.
                            </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Fee Category</label>
                                <select wire:model="editFeeCategoryId" @disabled($editAssignmentLocked)
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow disabled:bg-slate-100">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Academic Year</label>
                                <input type="text" wire:model="editAcademicYear" @disabled($editAssignmentLocked)
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow disabled:bg-slate-100">
                                @error('editAcademicYear')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Installment</label>
                                <input type="text" wire:model="editInstallmentNumber" @disabled($editAssignmentLocked)
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow disabled:bg-slate-100">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Amount</label>
                                <input type="number" step="0.01" wire:model="editAmount"
                                    @disabled($editAssignmentLocked)
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow disabled:bg-slate-100">
                                @error('editAmount')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Due Date</label>
                            <input type="date" wire:model="editDueDate"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            @error('editDueDate')
                                <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Remarks</label>
                            <textarea wire:model="editRemarks" rows="2"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>
                        </div>

                    </div>

                    <div class="bg-white border border-[#E2E8F0] rounded-xl px-5 py-4 flex justify-end gap-3">
                        <button type="button" wire:click="closeEditAssignmentModal"
                            class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">
                            Close
                        </button>
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4C81] text-white text-sm font-semibold transition">
                            <i class="fas fa-save text-xs"></i> Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if ($showDeleteAssignmentModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-sm overflow-hidden">

                <div class="bg-[#B91C1C] px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-full bg-white/15 flex items-center justify-center shrink-0">
                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                        </div>
                        <h3 class="text-white font-bold">Delete Fee Assignment</h3>
                    </div>
                </div>

                <div class="p-5 text-sm text-slate-700 space-y-2">
                    <p>Are you sure you want to delete this fee assignment?</p>
                    <p class="text-xs text-slate-400">This action cannot be undone.</p>
                </div>

                <div class="px-5 py-4 bg-[#F8FAFC] flex justify-end gap-2">
                    <button wire:click="closeDeleteAssignmentModal"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">
                        Cancel
                    </button>
                    <button wire:click="deleteAssignment"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#B91C1C] hover:bg-red-800 text-white text-sm font-semibold transition">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
