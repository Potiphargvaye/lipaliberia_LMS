<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Enrollment Management</h1>
            <p class="text-slate-500 text-sm mt-1">
                One record per Enrollment — created automatically when an Application is approved.
            </p>
        </div>

        <a href="{{ route('admin.admissions.index') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-[#155E8A] text-[#155E8A] font-semibold text-sm hover:bg-sky-50 transition-colors">
            <i class="fas fa-inbox text-xs"></i>
            View Admissions Queue
        </a>
    </div>

    {{-- Status Tabs --}}
    <div class="flex flex-wrap gap-2 border-b border-[#E2E8F0] pb-3">
        @foreach ([
        'enrolled' => 'Enrolled',
        'in_training' => 'In Training',
        'completed' => 'Completed',
        'withdrawn' => 'Withdrawn',
        'suspended' => 'Suspended',
    ] as $value => $label)
            <button type="button" wire:click="$set('status', '{{ $value }}')"
                class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2
                    {{ $status === $value ? 'bg-[#155E8A] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                {{ $label }}
                <span
                    class="inline-flex items-center justify-center min-w-[1.4rem] h-5 px-1 rounded-full text-[11px] font-bold
                        {{ $status === $value ? 'bg-white/20 text-white' : 'bg-white text-slate-500' }}">
                    {{ $statusCounts[$value] ?? 0 }}
                </span>
            </button>
        @endforeach
    </div>

    {{-- Search --}}
    <div class="bg-slate-50 border border-[#E2E8F0] rounded-xl p-3 sm:p-4">
        <div class="relative">
            <i class="fas fa-magnifying-glass text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input type="text" wire:model.live.debounce.350ms="search"
                placeholder="Search by student name or Student ID..."
                class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[960px]">
                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Student</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Course</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Cohort</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Progress</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Certificate</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($enrollments as $enrollment)
                        <tr wire:key="enrollment-{{ $enrollment->id }}" class="hover:bg-sky-50/60 transition-colors">

                            <td class="px-6 py-4">
                                <a href="{{ route('admin.students.show', $enrollment->student) }}"
                                    class="font-semibold text-slate-800 hover:text-[#155E8A] transition-colors">
                                    {{ $enrollment->student->name }}
                                </a>
                                <div class="text-xs text-slate-400 font-mono">
                                    {{ $enrollment->student->user?->registration_id ?? '—' }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $enrollment->course->title ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $enrollment->intake->name ?? '—' }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-20 h-2 rounded-full bg-slate-100 overflow-hidden">
                                        <div class="h-full bg-[#155E8A]"
                                            style="width: {{ $enrollment->progress_percentage ?? 0 }}%"></div>
                                    </div>
                                    <span class="text-xs text-slate-500 w-8 text-right">
                                        {{ $enrollment->progress_percentage ?? 0 }}%
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($enrollment->certificate_issued)
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                        <i class="fas fa-certificate mr-1"></i> Issued
                                    </span>
                                @else
                                    <span
                                        class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-semibold">
                                        Not Issued
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap justify-center gap-2">

                                    @if ($canManage)
                                        @if ($enrollment->status === 'enrolled')
                                            <button wire:click="markInTraining({{ $enrollment->id }})"
                                                wire:confirm="Move this student to In Training?"
                                                class="px-3 py-1.5 rounded-lg bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] text-xs font-semibold transition-colors">
                                                Start Training
                                            </button>
                                        @endif

                                        @if ($enrollment->status === 'in_training')
                                            <button wire:click="complete({{ $enrollment->id }})"
                                                wire:confirm="Mark this enrollment as completed?"
                                                class="px-3 py-1.5 rounded-lg bg-green-100 hover:bg-green-700 hover:text-white text-green-700 text-xs font-semibold transition-colors">
                                                Complete
                                            </button>
                                        @endif

                                        @if (in_array($enrollment->status, ['enrolled', 'in_training']))
                                            <button wire:click="confirmProgress({{ $enrollment->id }})"
                                                class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-700 hover:text-white text-slate-600 text-xs font-semibold transition-colors">
                                                Progress
                                            </button>

                                            <button wire:click="suspend({{ $enrollment->id }})"
                                                wire:confirm="Suspend this enrollment?"
                                                class="px-3 py-1.5 rounded-lg bg-amber-100 hover:bg-amber-600 hover:text-white text-amber-700 text-xs font-semibold transition-colors">
                                                Suspend
                                            </button>

                                            <button wire:click="confirmWithdraw({{ $enrollment->id }})"
                                                class="px-3 py-1.5 rounded-lg bg-red-100 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] text-xs font-semibold transition-colors">
                                                Withdraw
                                            </button>
                                        @endif

                                        @if ($enrollment->status === 'suspended')
                                            <button wire:click="confirmReactivate({{ $enrollment->id }})"
                                                class="px-3 py-1.5 rounded-lg bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] text-xs font-semibold transition-colors">
                                                Reactivate
                                            </button>
                                        @endif

                                        @if ($enrollment->status === 'completed' && !$enrollment->certificate_issued)
                                            <button wire:click="confirmIssueCertificate({{ $enrollment->id }})"
                                                class="px-3 py-1.5 rounded-lg bg-[#F97316] hover:bg-orange-600 text-white text-xs font-semibold transition-colors">
                                                Issue Certificate
                                            </button>
                                        @endif
                                    @endif

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-16">
                                <i class="fas fa-graduation-cap text-5xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500 text-sm">
                                    No enrollments found in this status.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-slate-50 px-4 sm:px-6 py-4 border-t border-[#E2E8F0]">
            {{ $enrollments->links() }}
        </div>
    </div>

    {{-- Withdraw Modal --}}
    @if ($showWithdrawModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center px-3 z-50">
            <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md overflow-hidden">
                <div class="bg-[#B91C1C] px-6 py-5">
                    <h2 class="text-white text-lg font-bold">Withdraw Enrollment</h2>
                </div>
                <div class="p-6 bg-[#F8FAFC] space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Reason for withdrawal</label>
                    <textarea wire:model="withdrawReason" rows="3"
                        class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-red-300 focus:border-red-400"></textarea>
                    @error('withdrawReason')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end gap-2">
                    <button wire:click="closeWithdrawModal"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="withdrawEnrollment"
                        class="px-5 py-2.5 rounded-lg bg-[#B91C1C] hover:bg-red-800 text-white font-semibold text-sm transition-colors">
                        Confirm Withdrawal
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Reactivate Modal --}}
    @if ($showReactivateModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center px-3 z-50">
            <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md overflow-hidden">
                <div class="bg-[#155E8A] px-6 py-5">
                    <h2 class="text-white text-lg font-bold">Reactivate Enrollment</h2>
                </div>
                <div class="p-6 bg-[#F8FAFC] space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Resume into which status?</label>
                    <select wire:model="reactivateTargetStatus"
                        class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                        <option value="enrolled">Enrolled</option>
                        <option value="in_training">In Training</option>
                    </select>
                </div>
                <div class="px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end gap-2">
                    <button wire:click="closeReactivateModal"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="reactivateEnrollment"
                        class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0B3A57] text-white font-semibold text-sm transition-colors">
                        Reactivate
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Progress Modal --}}
    @if ($showProgressModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center px-3 z-50">
            <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md overflow-hidden">
                <div class="bg-[#155E8A] px-6 py-5">
                    <h2 class="text-white text-lg font-bold">Update Progress</h2>
                </div>
                <div class="p-6 bg-[#F8FAFC] space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Progress (%)</label>
                    <input type="number" min="0" max="100" wire:model="progressValue"
                        class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                    @error('progressValue')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end gap-2">
                    <button wire:click="closeProgressModal"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="saveProgress"
                        class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0B3A57] text-white font-semibold text-sm transition-colors">
                        Save
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Issue Certificate Modal --}}
    @if ($showCertificateModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center px-3 z-50">
            <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md overflow-hidden">
                <div class="bg-[#F97316] px-6 py-5">
                    <h2 class="text-white text-lg font-bold">Issue Certificate</h2>
                </div>
                <div class="p-6 bg-[#F8FAFC] space-y-3">
                    <label class="block text-sm font-semibold text-slate-700">Certificate File (PDF)</label>
                    <input type="file" wire:model="certificateFile" accept=".pdf"
                        class="w-full text-sm rounded-lg border-slate-300 focus:ring-2 focus:ring-orange-300 focus:border-orange-400">
                    <div wire:loading wire:target="certificateFile" class="text-xs text-slate-400">Uploading...</div>
                    @error('certificateFile')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end gap-2">
                    <button wire:click="closeCertificateModal"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="issueCertificate" wire:loading.attr="disabled" wire:target="issueCertificate"
                        class="px-5 py-2.5 rounded-lg bg-[#F97316] hover:bg-orange-600 text-white font-semibold text-sm transition-colors disabled:opacity-60">
                        Issue Certificate
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
