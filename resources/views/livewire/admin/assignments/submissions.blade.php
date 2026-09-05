<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    <!-- Header -->
    <div class="relative bg-[#155E8A] rounded-xl px-5 py-5 overflow-hidden">

        <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#B91C1C]"></div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

            <div class="flex items-center gap-3">
                <div
                    class="h-11 w-11 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5 shrink-0">
                    <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}" alt="LIPA Logo"
                        class="h-full w-full object-contain">
                </div>
                <div>
                    <h1 class="text-white text-lg sm:text-xl font-bold">Assignment Submissions</h1>
                    <p class="text-sky-100 text-sm mt-0.5">
                        {{ $assignment->title }} {{ $assignment->module->course->title ?? '—' }} Module
                        {{ $assignment->module->module_order ?? '?' }}
                    </p>
                </div>
            </div>

            <div class="flex gap-2 shrink-0">
                <a href="{{ route('admin.assignments.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white/10 border border-white/25 text-white font-semibold text-sm hover:bg-white/20 transition">
                    <i class="fas fa-arrow-left text-xs"></i> Back to Assignments
                </a>
            </div>

        </div>

    </div>

    <!-- Search & Filter -->
    <div class="flex flex-col sm:flex-row gap-3">
        <div class="relative max-w-sm w-full">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search student..."
                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
        </div>
        <div class="max-w-xs w-full">
            <select wire:model.live="statusFilter"
                class="w-full py-2.5 px-3 rounded-lg border border-slate-300 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                <option value="">All Students</option>
                <option value="submitted">Submitted</option>
                <option value="not_submitted">Not Submitted</option>
                <option value="graded">Graded</option>
                <option value="ungraded">Submitted — Not Graded</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden overflow-x-auto">

        <table class="w-full text-sm min-w-[960px]">
            <thead class="bg-[#F8FAFC] text-slate-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left w-12">#</th>
                    <th class="px-4 py-3 text-left">Student</th>
                    <th class="px-4 py-3 text-left">Course</th>
                    <th class="px-4 py-3 text-left">Submitted</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Grade</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse($enrollments as $enrollment)
                    <tr class="hover:bg-[#155E8A]/5 transition">

                        <td class="px-4 py-3 text-slate-400 font-medium">
                            {{ ($enrollments->currentPage() - 1) * $enrollments->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-4 py-3 font-semibold text-slate-800">
                            {{ $enrollment->student->user->name ?? ($enrollment->student->name ?? '—') }}
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $assignment->module->course->title ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $enrollment->submission?->submitted_at?->format('M d, Y g:i A') ?? 'Not yet!' }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            @if (!$enrollment->submission)
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">Not
                                    Submitted</span>
                            @elseif ($enrollment->submission->isGraded())
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Graded</span>
                            @else
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Pending
                                    Review</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center font-semibold text-slate-700">
                            {{ $enrollment->submission?->isGraded() ? number_format($enrollment->submission->grade, 1) . '%' : 'Not yet!' }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">
                                @if ($enrollment->submission)
                                    <button wire:click="openReview({{ $enrollment->submission->id }})"
                                        class="h-8 w-8 rounded-md bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] flex items-center justify-center transition"
                                        title="Review">
                                        <i class="fas fa-eye text-xs"></i>
                                    </button>
                                @else
                                    <span class="text-xs text-slate-300">—</span>
                                @endif
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 text-slate-500">
                            <i class="fas fa-user-graduate text-4xl text-slate-300 mb-3"></i>
                            <p>No students enrolled in this course yet.</p>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>

    @if ($enrollments->hasPages())
        <div class="pt-2">{{ $enrollments->links() }}</div>
    @endif

    {{-- REVIEW / GRADE MODAL --}}
    @if ($showReviewModal && $viewingSubmission)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">

            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-lg max-h-[92vh] flex flex-col overflow-hidden">

                <div class="relative bg-[#155E8A] px-6 py-5 shrink-0">
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold">
                                {{ $assignment->title }}
                            </p>
                            <h2 class="text-white text-lg font-bold">
                                {{ $viewingSubmission->student->name ?? '—' }}
                            </h2>
                        </div>
                        <button wire:click="closeReview"
                            class="h-10 w-10 rounded-lg bg-white/10 hover:bg-red-600 transition flex items-center justify-center text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto bg-[#F8FAFC] p-6 space-y-5">

                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-4">
                        <p class="text-xs font-semibold text-slate-500 uppercase mb-2">Submitted Work</p>

                        @if ($viewingSubmission->file_path)
                            <a href="{{ Storage::url($viewingSubmission->file_path) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4C81] text-white text-sm font-semibold transition">
                                <i class="fas fa-download"></i> Download Submission
                            </a>
                            <p class="mt-2 text-xs text-slate-400">
                                Submitted {{ $viewingSubmission->submitted_at?->format('M d, Y g:i A') }}
                            </p>
                        @else
                            <p class="text-sm text-slate-400">No file attached to this submission.</p>
                        @endif
                    </div>

                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-5 space-y-4">

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Grade (%)
                            </label>
                            <input type="number" min="0" max="100" step="0.1" wire:model="grade"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            @error('grade')
                                <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Feedback
                            </label>
                            <textarea wire:model="feedback" rows="4" placeholder="Feedback for the student..."
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>
                            @error('feedback')
                                <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($viewingSubmission->isGraded())
                            <p class="text-xs text-slate-400">
                                Last graded {{ $viewingSubmission->graded_at?->format('M d, Y g:i A') }}
                                by {{ $viewingSubmission->gradedBy?->name ?? '—' }}
                            </p>
                        @endif

                    </div>

                </div>

                <div class="bg-white border-t border-[#E2E8F0] px-6 py-4 flex justify-end gap-3 shrink-0">
                    <button wire:click="closeReview"
                        class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">
                        Cancel
                    </button>
                    <button wire:click="saveGrade" wire:loading.attr="disabled" wire:target="saveGrade"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4C81] disabled:opacity-60 text-white text-sm font-semibold transition">
                        <span wire:loading.remove wire:target="saveGrade"><i class="fas fa-check"></i> Save
                            Grade</span>
                        <span wire:loading wire:target="saveGrade"><i class="fas fa-spinner fa-spin"></i>
                            Saving...</span>
                    </button>
                </div>

            </div>

        </div>
    @endif

</div>
