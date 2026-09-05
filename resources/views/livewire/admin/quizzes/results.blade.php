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
                    <h1 class="text-white text-lg sm:text-xl font-bold">Quiz Results</h1>
                    <p class="text-sky-100 text-sm mt-0.5">
                        {{ $quiz->title }} {{ $quiz->module->course->title ?? '—' }} Module
                        {{ $quiz->module->module_order ?? '?' }}
                    </p>
                </div>

            </div>

            <div class="flex gap-2 shrink-0">
                <a href="{{ route('admin.quizzes.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white/10 border border-white/25 text-white font-semibold text-sm hover:bg-white/20 transition">
                    <i class="fas fa-arrow-left text-xs"></i> Back to Quizzes
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
                <option value="attempted">Attempted</option>
                <option value="not_attempted">Not Attempted</option>
                <option value="passed">Passed</option>
                <option value="failed">Failed</option>
            </select>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden overflow-x-auto">

        <table class="w-full text-sm min-w-[1000px]">

            <thead class="bg-[#F8FAFC] text-slate-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left w-12">#</th>
                    <th class="px-4 py-3 text-left">Student</th>
                    <th class="px-4 py-3 text-left">Course</th>
                    <th class="px-4 py-3 text-center">Attempts</th>
                    <th class="px-4 py-3 text-center">Best Score</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-left">Last Attempt</th>
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
                            {{ $quiz->module->course->title ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-center text-slate-600">
                            {{ $enrollment->attemptsCount }} / {{ $quiz->max_attempts }}
                        </td>

                        <td class="px-4 py-3 text-center font-semibold text-slate-700">
                            @if ($enrollment->bestAttempt && !is_null($enrollment->bestAttempt->score))
                                {{ number_format($enrollment->bestAttempt->score, 1) }}%
                            @else
                                —
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center">
                            @if ($enrollment->attemptsCount === 0)
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">Not
                                    Attempted</span>
                            @elseif ($enrollment->bestAttempt && $enrollment->bestAttempt->passed)
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Passed</span>
                            @elseif ($enrollment->lastAttempt && is_null($enrollment->lastAttempt->passed))
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">Pending</span>
                            @else
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Failed</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $enrollment->lastAttempt?->completed_at?->format('M d, Y g:i A') ?? 'Not yet!' }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">
                                @if ($enrollment->attemptsCount > 0)
                                    <button
                                        wire:click="viewStudentAttempts({{ $enrollment->student->user->id ?? 0 }}, '{{ addslashes($enrollment->student->user->name ?? ($enrollment->student->name ?? '—')) }}')"
                                        class="h-8 w-8 rounded-md bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] flex items-center justify-center transition"
                                        title="View Attempts">
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
                        <td colspan="8" class="text-center py-12 text-slate-500">
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

    {{-- STUDENT ATTEMPTS / ATTEMPT DETAIL MODAL --}}
    @if ($showModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">

            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden">

                <div class="relative bg-[#155E8A] px-6 py-5 shrink-0">
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold">
                                {{ $quiz->title }}
                            </p>
                            <h2 class="text-white text-lg font-bold">
                                {{ $viewingAttempt ? ($viewingAttempt->student->name ?? '—') . ' — Attempt #' . $viewingAttempt->attempt_number : $viewingStudentName }}
                            </h2>
                        </div>
                        <button wire:click="closeModal"
                            class="h-10 w-10 rounded-lg bg-white/10 hover:bg-red-600 transition flex items-center justify-center text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto bg-[#F8FAFC] p-6 space-y-4">

                    @if (!$viewingAttempt)

                        {{-- LEVEL 1: list of this student's attempts --}}

                        @forelse ($viewingStudentAttempts as $attempt)
                            <div
                                class="bg-white rounded-xl border border-[#E2E8F0] p-4 flex items-center justify-between gap-3">

                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Attempt
                                        #{{ $attempt->attempt_number }}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ $attempt->completed_at?->format('M d, Y g:i A') ?? 'Not completed' }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-3">

                                    <div class="text-right">
                                        <p class="text-sm font-bold text-slate-700">
                                            {{ !is_null($attempt->score) ? number_format($attempt->score, 1) . '%' : '—' }}
                                        </p>
                                        @if (is_null($attempt->passed))
                                            <span
                                                class="text-[10px] font-semibold uppercase text-slate-400">Pending</span>
                                        @elseif ($attempt->passed)
                                            <span
                                                class="text-[10px] font-semibold uppercase text-green-600">Passed</span>
                                        @else
                                            <span class="text-[10px] font-semibold uppercase text-red-600">Failed</span>
                                        @endif
                                    </div>

                                    <button wire:click="viewAttemptDetail({{ $attempt->id }})"
                                        class="h-8 w-8 rounded-md bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] flex items-center justify-center transition"
                                        title="View Answers">
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </button>

                                </div>

                            </div>
                        @empty
                            <div class="text-center py-10 text-slate-400 text-sm">
                                No attempts recorded.
                            </div>
                        @endforelse
                    @else
                        {{-- LEVEL 2: answer detail for one attempt --}}

                        <button wire:click="backToAttemptList"
                            class="text-[#155E8A] hover:underline text-xs font-medium inline-flex items-center gap-1.5">
                            <i class="fas fa-chevron-left text-[10px]"></i> Back to attempts
                        </button>

                        <div class="bg-white rounded-xl border border-[#E2E8F0] p-4 flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-500">Score</p>
                                <p class="text-lg font-bold text-slate-800">
                                    {{ !is_null($viewingAttempt->score) ? number_format($viewingAttempt->score, 1) . '%' : '—' }}
                                </p>
                            </div>
                            <div>
                                @if (is_null($viewingAttempt->passed))
                                    <span
                                        class="px-3 py-1.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">Pending</span>
                                @elseif ($viewingAttempt->passed)
                                    <span
                                        class="px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Passed</span>
                                @else
                                    <span
                                        class="px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Failed</span>
                                @endif
                            </div>
                        </div>

                        @foreach ($viewingAttempt->answers as $index => $answer)
                            <div class="bg-white rounded-xl border border-[#E2E8F0] p-4 space-y-3">

                                <div class="flex items-start justify-between gap-3">
                                    <p class="text-sm font-semibold text-slate-800">
                                        {{ $index + 1 }}. {{ $answer->question->question_text ?? '—' }}
                                    </p>

                                    @if (!is_null($answer->is_correct))
                                        @if ($answer->is_correct)
                                            <span
                                                class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-green-100 text-green-700">Correct</span>
                                        @else
                                            <span
                                                class="shrink-0 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-red-100 text-red-700">Incorrect</span>
                                        @endif
                                    @endif
                                </div>

                                <div class="space-y-1.5">
                                    @php $selectedIds = $answer->selectedOptions->pluck('id')->toArray(); @endphp

                                    @foreach ($answer->question->options ?? [] as $option)
                                        @php
                                            $wasSelected = in_array($option->id, $selectedIds);
                                        @endphp
                                        <div
                                            class="flex items-center gap-2 text-sm px-3 py-2 rounded-lg border
                                            {{ $option->is_correct ? 'border-green-300 bg-green-50' : ($wasSelected ? 'border-red-300 bg-red-50' : 'border-slate-200 bg-white') }}">

                                            @if ($wasSelected)
                                                <i class="fas fa-circle-dot text-xs text-[#155E8A]"></i>
                                            @else
                                                <i class="far fa-circle text-xs text-slate-300"></i>
                                            @endif

                                            <span
                                                class="{{ $option->is_correct ? 'text-green-800 font-medium' : 'text-slate-700' }}">
                                                {{ $option->option_text }}
                                            </span>

                                            @if ($option->is_correct)
                                                <i class="fas fa-check text-xs text-green-600 ml-auto"></i>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        @endforeach

                    @endif

                </div>

                <div class="bg-white border-t border-[#E2E8F0] px-6 py-4 flex justify-end shrink-0">
                    <button wire:click="closeModal"
                        class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4C81] text-white text-sm font-semibold transition">
                        Close
                    </button>
                </div>

            </div>

        </div>
    @endif

</div>
