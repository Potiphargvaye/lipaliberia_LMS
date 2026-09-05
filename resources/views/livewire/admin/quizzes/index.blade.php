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
                    <h1 class="text-white text-lg sm:text-xl font-bold">Quiz Management</h1>
                    <p class="text-sky-100 text-sm mt-0.5">Create and manage module quizzes and questions.</p>
                </div>

            </div>

            <div class="flex gap-2 shrink-0">
                <a href="{{ route('admin.modules.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white/10 border border-white/25 text-white font-semibold text-sm hover:bg-white/20 transition">
                    <i class="fas fa-arrow-left text-xs"></i> Back to Modules
                </a>

                <button wire:click="openCreateModal"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white text-[#155E8A] font-semibold text-sm hover:bg-sky-50 transition">
                    <i class="fas fa-plus text-xs"></i> New Quiz
                </button>
            </div>

        </div>

    </div>

    <!-- Search & Filter -->
    <div class="flex flex-col sm:flex-row gap-3">

        <div class="relative max-w-sm w-full">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Search quizzes, modules, courses..."
                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
        </div>

        <div class="max-w-xs w-full">
            <select wire:model.live="courseFilter"
                class="w-full py-2.5 px-3 rounded-lg border border-slate-300 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                <option value="">All Courses</option>
                @foreach ($allCourses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden overflow-x-auto">

        <table class="w-full text-sm min-w-[1000px]">

            <thead class="bg-[#F8FAFC] text-slate-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left w-12">#</th>
                    <th class="px-4 py-3 text-left">Quiz</th>
                    <th class="px-4 py-3 text-left">Course</th>
                    <th class="px-4 py-3 text-left">Module</th>
                    <th class="px-4 py-3 text-center">Questions</th>
                    <th class="px-4 py-3 text-center">Pass %</th>
                    <th class="px-4 py-3 text-center">Attempts</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-left">Created By</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse($quizzes as $quiz)
                    <tr class="hover:bg-[#155E8A]/5 transition">

                        <td class="px-4 py-3 text-slate-400 font-medium">
                            {{ ($quizzes->currentPage() - 1) * $quizzes->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="font-semibold text-slate-800">{{ $quiz->title }}</div>
                            @if ($quiz->is_required)
                                <span class="text-[10px] text-[#B91C1C] font-semibold uppercase">Required</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-slate-600">{{ $quiz->module->course->title ?? '—' }}</td>

                        <td class="px-4 py-3 text-slate-600">
                            Module {{ $quiz->module->module_order ?? '?' }}: {{ $quiz->module->title ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-center text-slate-600">{{ $quiz->questions_count }}</td>

                        <td class="px-4 py-3 text-center text-slate-600">{{ $quiz->passing_score }}%</td>

                        <td class="px-4 py-3 text-center text-slate-600">{{ $quiz->max_attempts }}</td>

                        <td class="px-4 py-3 text-center">
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $quiz->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-slate-600">{{ $quiz->createdBy?->name ?? '—' }}</td>

                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.quizzes.results', $quiz->id) }}"
                                    class="h-8 w-8 rounded-md bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] flex items-center justify-center transition"
                                    title="View Results">
                                    <i class="fas fa-chart-bar text-xs"></i>
                                </a>
                                <button wire:click="openEditModal({{ $quiz->id }})"
                                    class="h-8 w-8 rounded-md bg-yellow-100 hover:bg-yellow-500 hover:text-white text-yellow-700 flex items-center justify-center transition">
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $quiz->id }})"
                                    class="h-8 w-8 rounded-md bg-[#B91C1C]/10 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] flex items-center justify-center transition">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-12 text-slate-500">
                            <i class="fas fa-circle-question text-4xl text-slate-300 mb-3"></i>
                            <p>No quizzes found.</p>
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    @if ($quizzes->hasPages())
        <div class="pt-2">{{ $quizzes->links() }}</div>
    @endif

    {{-- CREATE / EDIT MODAL --}}
    @if ($showModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">

            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-3xl max-h-[92vh] flex flex-col overflow-hidden">

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
                                    {{ $editingId ? 'Edit Quiz' : 'Create Quiz' }}
                                </h2>
                            </div>
                        </div>
                        <button wire:click="closeModal"
                            class="h-10 w-10 rounded-lg bg-white/10 hover:bg-red-600 transition flex items-center justify-center text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="save" class="flex-1 overflow-y-auto bg-[#F8FAFC] p-6 space-y-5">

                    @if ($lockedByAttempts)
                        <div
                            class="bg-amber-50 border border-amber-200 rounded-lg p-3.5 text-xs text-amber-800 flex gap-2">
                            <i class="fas fa-lock mt-0.5"></i>
                            <span>Students have already attempted this quiz. Questions and options are locked to
                                protect their results only quiz settings below can be edited.</span>
                        </div>
                    @endif

                    <!-- Quiz Settings -->
                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-5 space-y-5">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Course</label>
                                <select wire:model.live="courseId"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                                    <option value="">Select a course...</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                                @error('courseId')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Module</label>
                                <select wire:model="moduleId" @if (!$courseId) disabled @endif
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow disabled:bg-slate-100">
                                    <option value="">
                                        {{ $courseId ? 'Select a module...' : 'Select a course first' }}</option>
                                    @foreach ($availableModules as $module)
                                        <option value="{{ $module->id }}">Module {{ $module->module_order }}:
                                            {{ $module->title }}</option>
                                    @endforeach
                                </select>
                                @error('moduleId')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Quiz Title</label>
                            <input type="text" wire:model="title" placeholder="e.g. Module 1 Knowledge Check"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            @error('title')
                                <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Description <span
                                    class="text-slate-400 font-normal">(Optional)</span></label>
                            <textarea wire:model="description" rows="2"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Passing Score
                                    (%)</label>
                                <input type="number" min="1" max="100" wire:model="passingScore"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                                @error('passingScore')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Max Attempts</label>
                                <input type="number" min="1" max="20" wire:model="maxAttempts"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                                @error('maxAttempts')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Time Limit (min) <span
                                        class="text-slate-400 font-normal">(Optional)</span></label>
                                <input type="number" min="1" wire:model="timeLimitMinutes"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-5">
                            <label class="flex items-center gap-2.5 text-sm text-slate-700">
                                <input type="checkbox" wire:model="isRequired"
                                    class="rounded border-slate-300 text-[#155E8A] focus:ring-[#155E8A]/30">
                                Required to complete the module
                            </label>
                            <label class="flex items-center gap-2.5 text-sm text-slate-700">
                                <input type="checkbox" wire:model="isActive"
                                    class="rounded border-slate-300 text-[#155E8A] focus:ring-[#155E8A]/30">
                                Active — available to students
                            </label>
                        </div>

                    </div>

                    {{-- Question Builder --}}
                    @if (!$lockedByAttempts)
                        <div class="bg-white rounded-xl border border-[#E2E8F0] p-5 space-y-5">

                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                    <i class="fas fa-list-check text-[#155E8A]"></i> Questions
                                </h3>
                                <button type="button" wire:click="addQuestion"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#155E8A]/10 text-[#155E8A] text-xs font-semibold hover:bg-[#155E8A]/20 transition">
                                    <i class="fas fa-plus text-[10px]"></i> Add Question
                                </button>
                            </div>

                            @error('questions')
                                <p class="text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                            @enderror

                            @foreach ($questions as $qIndex => $question)
                                <div wire:key="question-{{ $qIndex }}"
                                    class="bg-[#F8FAFC] rounded-lg border border-slate-200 p-4 space-y-3">

                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-[#155E8A] uppercase">Question
                                            {{ $qIndex + 1 }}</span>
                                        @if (count($questions) > 1)
                                            <button type="button" wire:click="removeQuestion({{ $qIndex }})"
                                                class="text-[#B91C1C] hover:underline text-xs font-medium">
                                                <i class="fas fa-trash text-[10px]"></i> Remove
                                            </button>
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                        <div class="sm:col-span-2">
                                            <input type="text"
                                                wire:model="questions.{{ $qIndex }}.question_text"
                                                placeholder="Question text"
                                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                                        </div>
                                        <div>
                                            <select wire:model="questions.{{ $qIndex }}.type"
                                                wire:change="changeQuestionType({{ $qIndex }})"
                                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                                                @foreach ($questionTypes as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        @foreach ($question['options'] as $oIndex => $option)
                                            <div wire:key="option-{{ $qIndex }}-{{ $oIndex }}"
                                                class="flex items-center gap-2">

                                                <button type="button"
                                                    wire:click="markCorrect({{ $qIndex }}, {{ $oIndex }})"
                                                    class="h-6 w-6 rounded-{{ $question['type'] === 'checkbox' ? 'md' : 'full' }} border-2 flex items-center justify-center shrink-0 transition
                                                    {{ $option['is_correct'] ? 'bg-green-500 border-green-500 text-white' : 'border-slate-300 text-transparent' }}">
                                                    <i class="fas fa-check text-[10px]"></i>
                                                </button>

                                                <input type="text"
                                                    wire:model="questions.{{ $qIndex }}.options.{{ $oIndex }}.option_text"
                                                    placeholder="Option text"
                                                    @if ($question['type'] === 'true_false') readonly @endif
                                                    class="flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow @if ($question['type'] === 'true_false') bg-slate-100 @endif">

                                                @if ($question['type'] !== 'true_false' && count($question['options']) > 2)
                                                    <button type="button"
                                                        wire:click="removeOption({{ $qIndex }}, {{ $oIndex }})"
                                                        class="text-slate-400 hover:text-[#B91C1C] transition">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                @endif

                                            </div>
                                        @endforeach

                                        @if ($question['type'] !== 'true_false')
                                            <button type="button" wire:click="addOption({{ $qIndex }})"
                                                class="text-[#155E8A] hover:underline text-xs font-medium">
                                                <i class="fas fa-plus text-[10px]"></i> Add option
                                            </button>
                                        @endif

                                        @error("questions.$qIndex.options")
                                            <p class="text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                        @enderror
                                        @error("questions.$qIndex.question_text")
                                            <p class="text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @endif

                    <div class="bg-white border border-[#E2E8F0] rounded-xl px-5 py-4 flex justify-end gap-3">
                        <button type="button" wire:click="closeModal"
                            class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">
                            Cancel
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="save"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4C81] disabled:opacity-60 text-white text-sm font-semibold transition">
                            <span wire:loading.remove wire:target="save"><i class="fas fa-save"></i> Save</span>
                            <span wire:loading wire:target="save"><i class="fas fa-spinner fa-spin"></i>
                                Saving...</span>
                        </button>
                    </div>

                </form>

            </div>

        </div>
    @endif

    {{-- DELETE MODAL --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-sm overflow-hidden">
                <div class="bg-[#B91C1C] px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-full bg-white/15 flex items-center justify-center shrink-0">
                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                        </div>
                        <h3 class="text-white font-bold">Delete Quiz</h3>
                    </div>
                </div>
                <div class="p-5 text-sm text-slate-700 space-y-2">
                    <p>Are you sure you want to delete this quiz?</p>
                    <p class="font-semibold text-slate-900">{{ $deleteQuizName }}</p>
                    <p class="text-xs text-slate-400">This action cannot be undone.</p>
                </div>
                <div class="px-5 py-4 bg-[#F8FAFC] flex justify-end gap-2">
                    <button wire:click="closeDeleteModal"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">
                        Cancel
                    </button>
                    <button wire:click="delete" wire:loading.attr="disabled" wire:target="delete"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#B91C1C] hover:bg-red-800 disabled:opacity-60 text-white text-sm font-semibold transition">
                        <span wire:loading.remove wire:target="delete"><i class="fas fa-trash"></i> Delete Quiz</span>
                        <span wire:loading wire:target="delete"><i class="fas fa-spinner fa-spin"></i>
                            Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
