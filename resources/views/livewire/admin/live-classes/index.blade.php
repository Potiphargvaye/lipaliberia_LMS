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
                    <h1 class="text-white text-lg sm:text-xl font-bold">
                        Live Class Schedule
                    </h1>

                    <p class="text-sky-100 text-sm mt-0.5">
                        Schedule and manage live sessions for your courses.
                    </p>
                </div>

            </div>


            @can('manage live classes')
                <div class="flex gap-2 shrink-0">

                    <button wire:click="openCreateModal"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white text-[#155E8A] font-semibold text-sm hover:bg-sky-50 transition">

                        <i class="fas fa-plus text-xs"></i>
                        New Live Class

                    </button>

                </div>
            @endcan

        </div>

    </div>


    <!-- Search + Filters -->
    <div class="space-y-3">

        <div class="relative max-w-sm">

            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>

            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search live classes..."
                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

        </div>

        <div class="flex flex-wrap gap-3">

            {{-- Course / Facilitator / Cohort filters only ever render for
                 unrestricted users — a scoped facilitator's view is already
                 limited to their assigned courses, so these filters would
                 either be redundant or leak the existence of other courses. --}}
            @if ($isUnrestricted)
                <select wire:model.live="courseFilter"
                    class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                    <option value="">All Courses</option>
                    @foreach ($filterCourseOptions as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>

                <select wire:model.live="facilitatorFilter"
                    class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                    <option value="">All Facilitators</option>
                    @foreach ($filterFacilitatorOptions as $facilitator)
                        <option value="{{ $facilitator->id }}">{{ $facilitator->name }}</option>
                    @endforeach
                </select>

                <select wire:model.live="cohortFilter"
                    class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                    <option value="">All Cohorts</option>
                    @foreach ($cohortOptions as $cohort)
                        <option value="{{ $cohort->id }}">{{ $cohort->name }}</option>
                    @endforeach
                </select>
            @endif

            <select wire:model.live="statusFilter"
                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                <option value="">All Statuses</option>
                <option value="scheduled">Scheduled</option>
                <option value="live">Live</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <input type="date" wire:model.live="dateFilter"
                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">

        </div>

    </div>



    <!-- Table -->

    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden overflow-x-auto">

        <table class="w-full text-sm min-w-[1080px]">

            <thead class="bg-[#F8FAFC] text-slate-500 text-xs uppercase">

                <tr>
                    <th class="px-4 py-3 text-left w-12">#</th>
                    <th class="px-4 py-3 text-left">Live Class</th>
                    <th class="px-4 py-3 text-left">Course</th>
                    <th class="px-4 py-3 text-left">Module</th>
                    <th class="px-4 py-3 text-left">Cohort</th>
                    <th class="px-4 py-3 text-left">Facilitator</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Time</th>
                    <th class="px-4 py-3 text-left">Platform</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">

                @forelse($liveClasses as $liveClass)
                    <tr class="hover:bg-[#155E8A]/5 transition">

                        <td class="px-4 py-3 text-slate-400 font-medium">
                            {{ ($liveClasses->currentPage() - 1) * $liveClasses->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="font-semibold text-slate-800">{{ $liveClass->title }}</div>
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $liveClass->course?->title ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $liveClass->module?->title ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $liveClass->cohort?->name ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $liveClass->facilitator?->name ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $liveClass->date?->format('M d, Y') }}
                        </td>

                        <td class="px-4 py-3 text-slate-600 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($liveClass->start_time)->format('g:i A') }}
                            &ndash;
                            {{ \Carbon\Carbon::parse($liveClass->end_time)->format('g:i A') }}
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ ucfirst(str_replace('_', ' ', $liveClass->platform)) }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            @php
                                $statusStyles = [
                                    'scheduled' => 'bg-sky-100 text-sky-700',
                                    'live' => 'bg-green-100 text-green-700',
                                    'completed' => 'bg-slate-100 text-slate-500',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusStyles[$liveClass->status] ?? 'bg-slate-100 text-slate-500' }}">
                                {{ ucfirst($liveClass->status) }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">

                                <button wire:click="openViewModal({{ $liveClass->id }})"
                                    class="h-8 w-8 rounded-md bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] flex items-center justify-center transition">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>

                                @can('manage live classes')
                                    <button wire:click="openEditModal({{ $liveClass->id }})"
                                        class="h-8 w-8 rounded-md bg-yellow-100 hover:bg-yellow-500 hover:text-white text-yellow-700 flex items-center justify-center transition">
                                        <i class="fas fa-pen text-xs"></i>
                                    </button>

                                    <button wire:click="confirmDelete({{ $liveClass->id }})"
                                        class="h-8 w-8 rounded-md bg-[#B91C1C]/10 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] flex items-center justify-center transition">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                @endcan

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="11" class="text-center py-12 text-slate-500">
                            <i class="fas fa-video text-4xl text-slate-300 mb-3"></i>
                            <p>No live classes found.</p>
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    @if ($liveClasses->hasPages())
        <div class="pt-2">
            {{ $liveClasses->links() }}
        </div>
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
                                    {{ $editingId ? 'Edit Live Class' : 'Schedule Live Class' }}
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

                    <!-- Section 1: Course, Module, Cohort, Facilitator -->
                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-5">

                        <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <i class="fas fa-book text-[#155E8A]"></i>
                            Course &amp; Assignment
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Course</label>

                                <select wire:model.live="courseId"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                                    <option value="">Select a course...</option>
                                    @foreach ($courseOptions as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>

                                @error('courseId')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Module <span class="text-slate-400 font-normal">(optional)</span>
                                </label>

                                <select wire:model="moduleId" @if (!$courseId) disabled @endif
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow disabled:bg-slate-100 disabled:cursor-not-allowed">
                                    <option value="">No specific module</option>
                                    @foreach ($moduleOptions as $module)
                                        <option value="{{ $module->id }}">{{ $module->title }}</option>
                                    @endforeach
                                </select>

                                @error('moduleId')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Cohort <span class="text-slate-400 font-normal">(optional)</span>
                                </label>

                                <select wire:model="cohortId"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                                    <option value="">No specific cohort</option>
                                    @foreach ($cohortOptions as $cohort)
                                        <option value="{{ $cohort->id }}">{{ $cohort->name }}</option>
                                    @endforeach
                                </select>

                                @error('cohortId')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Facilitator</label>

                                <select wire:model="facilitatorId" @if (!$courseId) disabled @endif
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow disabled:bg-slate-100 disabled:cursor-not-allowed">
                                    <option value="">
                                        {{ $courseId ? 'Select a facilitator...' : 'Select a course first' }}
                                    </option>
                                    @foreach ($facilitatorOptions as $facilitator)
                                        <option value="{{ $facilitator->id }}">{{ $facilitator->name }}</option>
                                    @endforeach
                                </select>

                                @if ($courseId && $facilitatorOptions->isEmpty())
                                    <p class="mt-1 text-xs text-slate-400">
                                        No facilitators are assigned to this course yet.
                                    </p>
                                @endif

                                @error('facilitatorId')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>


                    <!-- Section 2: Session Details -->
                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-5">

                        <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <i class="fas fa-align-left text-[#155E8A]"></i>
                            Session Details
                        </h3>

                        <div class="space-y-5">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Title</label>

                                <input type="text" wire:model="title" placeholder="e.g. Module 1 Orientation"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('title')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Description / Agenda
                                </label>

                                <textarea wire:model="description" rows="3" placeholder="What will this session cover?"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>

                                @error('description')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>


                    <!-- Section 3: Schedule & Platform -->
                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-5">

                        <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-[#155E8A]"></i>
                            Schedule &amp; Platform
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Date</label>

                                <input type="date" wire:model="date"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('date')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>

                                <select wire:model="status"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                                    <option value="scheduled">Scheduled</option>
                                    <option value="live">Live</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>

                                @error('status')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Start Time</label>

                                <input type="time" wire:model="startTime"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('startTime')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">End Time</label>

                                <input type="time" wire:model="endTime"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('endTime')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Platform</label>

                                <select wire:model="platform"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                                    <option value="">Select platform...</option>
                                    <option value="google_meet">Google Meet</option>
                                    <option value="zoom">Zoom</option>
                                    <option value="teams">Microsoft Teams</option>
                                    <option value="other">Other</option>
                                </select>

                                @error('platform')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Meeting URL</label>

                                <input type="url" wire:model="meetingUrl" placeholder="https://..."
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('meetingUrl')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>


                    <!-- Footer -->
                    <div class="bg-white border border-[#E2E8F0] rounded-xl px-5 py-4 flex justify-end gap-3">

                        <button type="button" wire:click="closeModal"
                            class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">
                            Cancel
                        </button>

                        <button type="submit" wire:loading.attr="disabled" wire:target="save"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4C81] disabled:opacity-60 disabled:cursor-not-allowed text-white text-sm font-semibold transition">

                            <span wire:loading.remove wire:target="save">
                                <i class="fas fa-save"></i>
                                Save
                            </span>

                            <span wire:loading wire:target="save">
                                <i class="fas fa-spinner fa-spin"></i>
                                Saving...
                            </span>

                        </button>

                    </div>

                </form>

            </div>

        </div>
    @endif




    {{-- VIEW MODAL --}}

    @if ($showViewModal && $viewingLiveClass)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">

            <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-lg overflow-hidden">

                <div class="relative bg-[#155E8A] px-6 py-5">

                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#B91C1C]"></div>

                    <div class="flex items-start justify-between gap-3">
                        <h2 class="text-white text-lg font-bold">{{ $viewingLiveClass->title }}</h2>

                        <button wire:click="closeViewModal"
                            class="h-9 w-9 rounded-lg bg-white/10 hover:bg-red-600 transition flex items-center justify-center text-white">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="p-6 space-y-4 text-sm">

                    @if ($viewingLiveClass->description)
                        <p class="text-slate-600">{{ $viewingLiveClass->description }}</p>
                    @endif

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <p class="text-xs uppercase text-slate-400 font-semibold">Course</p>
                            <p class="text-slate-700 font-medium">{{ $viewingLiveClass->course?->title ?? '—' }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-slate-400 font-semibold">Module</p>
                            <p class="text-slate-700 font-medium">{{ $viewingLiveClass->module?->title ?? '—' }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-slate-400 font-semibold">Cohort</p>
                            <p class="text-slate-700 font-medium">{{ $viewingLiveClass->cohort?->name ?? '—' }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-slate-400 font-semibold">Facilitator</p>
                            <p class="text-slate-700 font-medium">{{ $viewingLiveClass->facilitator?->name ?? '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-slate-400 font-semibold">Date</p>
                            <p class="text-slate-700 font-medium">{{ $viewingLiveClass->date?->format('M d, Y') }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-slate-400 font-semibold">Time</p>
                            <p class="text-slate-700 font-medium">
                                {{ \Carbon\Carbon::parse($viewingLiveClass->start_time)->format('g:i A') }}
                                &ndash;
                                {{ \Carbon\Carbon::parse($viewingLiveClass->end_time)->format('g:i A') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-slate-400 font-semibold">Platform</p>
                            <p class="text-slate-700 font-medium">
                                {{ ucfirst(str_replace('_', ' ', $viewingLiveClass->platform)) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-slate-400 font-semibold">Status</p>
                            <p class="text-slate-700 font-medium">{{ ucfirst($viewingLiveClass->status) }}</p>
                        </div>

                    </div>

                    <div>
                        <p class="text-xs uppercase text-slate-400 font-semibold mb-1">Meeting Link</p>
                        <a href="{{ $viewingLiveClass->meeting_url }}" target="_blank"
                            class="text-[#155E8A] font-medium break-all hover:underline">
                            {{ $viewingLiveClass->meeting_url }}
                        </a>
                    </div>

                </div>

                <div class="px-6 py-4 bg-[#F8FAFC] flex justify-end">
                    <button wire:click="closeViewModal"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">
                        Close
                    </button>
                </div>

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
                        <h3 class="text-white font-bold">Delete Live Class</h3>
                    </div>
                </div>

                <div class="p-5 text-sm text-slate-700 space-y-2">
                    <p>Are you sure you want to delete this live class?</p>
                    <p class="font-semibold text-slate-900">{{ $deleteTitle }}</p>
                    <p class="text-xs text-slate-400">This action cannot be undone.</p>
                </div>

                <div class="px-5 py-4 bg-[#F8FAFC] flex justify-end gap-2">

                    <button wire:click="closeDeleteModal"
                        class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">
                        Cancel
                    </button>

                    <button wire:click="delete" wire:loading.attr="disabled" wire:target="delete"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#B91C1C] hover:bg-red-800 disabled:opacity-60 text-white text-sm font-semibold transition">

                        <span wire:loading.remove wire:target="delete">
                            <i class="fas fa-trash"></i>
                            Delete Live Class
                        </span>

                        <span wire:loading wire:target="delete">
                            <i class="fas fa-spinner fa-spin"></i>
                            Deleting...
                        </span>

                    </button>

                </div>

            </div>

        </div>
    @endif

</div>
