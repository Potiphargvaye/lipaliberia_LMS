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
                        Course Management
                    </h1>

                    <p class="text-sky-100 text-sm mt-0.5">
                        Manage available courses, programmes, and training information.
                    </p>
                </div>

            </div>


            <div class="flex gap-2 shrink-0">

                <a href="{{ route('admin.fees.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white/10 border border-white/25 text-white font-semibold text-sm hover:bg-white/20 transition">

                    <i class="fas fa-arrow-left text-xs"></i>
                    Back

                </a>


                <button wire:click="openCreateModal"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white text-[#155E8A] font-semibold text-sm hover:bg-sky-50 transition">

                    <i class="fas fa-plus text-xs"></i>
                    New Course

                </button>

            </div>

        </div>

    </div>


    <!-- Search -->
    <div class="relative max-w-sm">

        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>

        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search courses..."
            class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

    </div>



    <!-- Table -->

    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden overflow-x-auto">

        <table class="w-full text-sm min-w-[960px]">

            <thead class="bg-[#F8FAFC] text-slate-500 text-xs uppercase">

                <tr>

                    <th class="px-4 py-3 text-left w-12">
                        #
                    </th>

                    <th class="px-4 py-3 text-left">
                        Course Title
                    </th>

                    <th class="px-4 py-3 text-left">
                        Category
                    </th>

                    <th class="px-4 py-3 text-left">
                        Programme Type
                    </th>

                    <th class="px-4 py-3 text-left">
                        Duration
                    </th>

                    <th class="px-4 py-3 text-right">
                        Fee
                    </th>

                    <th class="px-4 py-3 text-center">
                        Status
                    </th>

                    <th class="px-4 py-3 text-center">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">


                @forelse($courses as $course)
                    <tr class="hover:bg-[#155E8A]/5 transition">


                        <td class="px-4 py-3 text-slate-400 font-medium">

                            {{ ($courses->currentPage() - 1) * $courses->perPage() + $loop->iteration }}

                        </td>


                        <td class="px-4 py-3">

                            <div class="font-semibold text-slate-800">
                                {{ $course->title }}
                            </div>

                            <div class="text-xs text-slate-400 font-mono">
                                {{ $course->slug }}
                            </div>

                        </td>



                        <td class="px-4 py-3 text-slate-600">

                            {{ $course->category ?? '—' }}

                        </td>



                        <td class="px-4 py-3 text-slate-600">

                            {{ $course->programme_type ?? '—' }}

                        </td>



                        <td class="px-4 py-3 text-slate-600">

                            {{ $course->duration ?? '—' }}

                        </td>



                        <td class="px-4 py-3 text-right font-semibold text-slate-700">

                            @if ($course->fee)
                                ${{ number_format($course->fee, 2) }}
                            @else
                                —
                            @endif

                        </td>




                        <td class="px-4 py-3 text-center">

                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-medium
                            {{ $course->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">

                                {{ $course->is_active ? 'Active' : 'Inactive' }}

                            </span>

                        </td>




                        <td class="px-4 py-3">

                            <div class="flex justify-center gap-2">


                                <button wire:click="openEditModal({{ $course->id }})"
                                    class="h-8 w-8 rounded-md bg-yellow-100 hover:bg-yellow-500 hover:text-white text-yellow-700 flex items-center justify-center transition">

                                    <i class="fas fa-pen text-xs"></i>

                                </button>




                                <button wire:click="confirmDelete({{ $course->id }})"
                                    class="h-8 w-8 rounded-md bg-[#B91C1C]/10 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] flex items-center justify-center transition">

                                    <i class="fas fa-trash text-xs"></i>

                                </button>


                            </div>

                        </td>


                    </tr>


                @empty

                    <tr>

                        <td colspan="8" class="text-center py-12 text-slate-500">

                            <i class="fas fa-book text-4xl text-slate-300 mb-3"></i>

                            <p>
                                No courses found.
                            </p>

                        </td>

                    </tr>
                @endforelse


            </tbody>


        </table>


    </div>

    @if ($courses->hasPages())
        <div class="pt-2">
            {{ $courses->links() }}
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
                                    {{ $editingId ? 'Edit Course' : 'Create Course' }}
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


                    <!-- Section 1: Basic Information -->
                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-5">

                        <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <i class="fas fa-info-circle text-[#155E8A]"></i>
                            Basic Information
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Course Title
                                </label>

                                <input type="text" wire:model.live="title"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('title')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Slug
                                </label>

                                <input type="text" wire:model="slug" readonly
                                    class="w-full rounded-lg border border-slate-300 bg-slate-100 px-3 py-2.5 text-sm text-slate-500 shadow-sm cursor-not-allowed">

                                @error('slug')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Category
                                </label>

                                <input type="text" wire:model="category" placeholder="e.g. Short Course"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('category')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Programme Type
                                </label>

                                <input type="text" wire:model="programmeType" placeholder="e.g. Certificate"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('programmeType')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Group
                                </label>

                                <input type="text" wire:model="group" placeholder="Group key"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Group Label
                                </label>

                                <input type="text" wire:model="groupLabel" placeholder="Display label for group"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            </div>

                        </div>

                    </div>


                    <!-- Section 2: Course Details -->
                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-5">

                        <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <i class="fas fa-align-left text-[#155E8A]"></i>
                            Course Details
                        </h3>

                        <div class="space-y-5">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Overview
                                </label>

                                <textarea wire:model="overview" rows="3" placeholder="Course overview"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>

                                @error('overview')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Target Audience
                                </label>

                                <textarea wire:model="targetAudience" rows="2" placeholder="Who this course is for"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Entry Requirements
                                </label>

                                <textarea wire:model="entryRequirements" rows="2" placeholder="Prerequisites, if any"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>
                            </div>

                        </div>

                    </div>


                    <!-- Section 3: Logistics -->
                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-5">

                        <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <i class="fas fa-clipboard-list text-[#155E8A]"></i>
                            Logistics
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Duration
                                </label>

                                <input type="text" wire:model="duration" placeholder="e.g. 6 weeks"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('duration')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Schedule
                                </label>

                                <input type="text" wire:model="schedule" placeholder="e.g. Weekends"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Fee
                                </label>

                                <input type="number" step="0.01" wire:model="fee" placeholder="0.00"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('fee')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Seats
                                </label>

                                <input type="number" wire:model="seats" placeholder="Available seats"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('seats')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>


                    <!-- Section 4: Publication -->
                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-5">

                        <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                            <i class="fas fa-globe text-[#155E8A]"></i>
                            Publication
                        </h3>

                        <label class="flex items-center gap-2.5 text-sm text-slate-700">

                            <input type="checkbox" wire:model="isActive"
                                class="rounded border-slate-300 text-[#155E8A] focus:ring-[#155E8A]/30">

                            Active — visible and open for enrollment

                        </label>

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




    {{-- DELETE MODAL --}}

    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">


            <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-sm overflow-hidden">


                <div class="bg-[#B91C1C] px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="h-9 w-9 rounded-full bg-white/15 flex items-center justify-center shrink-0">
                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                        </div>

                        <h3 class="text-white font-bold">
                            Delete Course
                        </h3>

                    </div>

                </div>


                <div class="p-5 text-sm text-slate-700 space-y-2">

                    <p>
                        Are you sure you want to delete this course?
                    </p>

                    <p class="font-semibold text-slate-900">
                        {{ $deleteCourseName }}
                    </p>

                    <p class="text-xs text-slate-400">
                        This action cannot be undone.
                    </p>

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
                            Delete Course
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
