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
                        Lesson Module Management
                    </h1>

                    <p class="text-sky-100 text-sm mt-0.5">
                        Organize course content into structured learning modules.
                    </p>
                </div>

            </div>

            <div class="flex gap-2 shrink-0">

                <a href="{{ route('admin.courses.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white/10 border border-white/25 text-white font-semibold text-sm hover:bg-white/20 transition">

                    <i class="fas fa-arrow-left text-xs"></i>
                    Back to Courses

                </a>

                <button wire:click="openCreateModal"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white text-[#155E8A] font-semibold text-sm hover:bg-sky-50 transition">

                    <i class="fas fa-plus text-xs"></i>
                    New Module

                </button>

            </div>

        </div>

    </div>

    <!-- Search & Filter -->
    <div class="flex flex-col sm:flex-row gap-3">

        <div class="relative max-w-sm w-full">

            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>

            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search modules or courses..."
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

        <table class="w-full text-sm min-w-[960px]">

            <thead class="bg-[#F8FAFC] text-slate-500 text-xs uppercase">

                <tr>
                    <th class="px-4 py-3 text-left w-12">#</th>
                    <th class="px-4 py-3 text-left">Module</th>
                    <th class="px-4 py-3 text-left">Course</th>
                    <th class="px-4 py-3 text-left">Order</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-left">Created By</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>

            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse($modules as $module)
                    <tr class="hover:bg-[#155E8A]/5 transition">

                        <td class="px-4 py-3 text-slate-400 font-medium">
                            {{ ($modules->currentPage() - 1) * $modules->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="font-semibold text-slate-800">
                                Module: {{ $module->module_order }}: {{ $module->title }}
                            </div>
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $module->course->title ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $module->module_order }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $module->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $module->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $module->createdBy?->name ?? '—' }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">

                                <button wire:click="openEditModal({{ $module->id }})"
                                    class="h-8 w-8 rounded-md bg-yellow-100 hover:bg-yellow-500 hover:text-white text-yellow-700 flex items-center justify-center transition">
                                    <i class="fas fa-pen text-xs"></i>
                                </button>

                                <button wire:click="confirmDelete({{ $module->id }})"
                                    class="h-8 w-8 rounded-md bg-[#B91C1C]/10 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] flex items-center justify-center transition">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 text-slate-500">
                            <i class="fas fa-layer-group text-4xl text-slate-300 mb-3"></i>
                            <p>No modules found here!.</p>
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    @if ($modules->hasPages())
        <div class="pt-2">
            {{ $modules->links() }}
        </div>
    @endif

    {{-- CREATE / EDIT MODAL --}}

    @if ($showModal)
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

                            <div>
                                <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold">
                                    Liberia Institute of Public Administration
                                </p>

                                <h2 class="text-white text-lg font-bold">
                                    {{ $editingId ? 'Edit Module' : 'Create Lesson Module' }}
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

                    <div class="bg-white rounded-xl border border-[#E2E8F0] p-5 space-y-5">

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Course
                            </label>

                            <select wire:model="courseId"
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
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Module Title
                            </label>

                            <input type="text" wire:model="title"
                                placeholder="e.g. Introduction to Public Procurement"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                            <p class="mt-1 text-xs text-slate-400">
                                Do not include "Module X:" — the number is generated automatically from Module
                                Order.
                            </p>

                            @error('title')
                                <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Module Order
                            </label>

                            <input type="number" min="1" wire:model="moduleOrder" placeholder="e.g. 1"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                            @error('moduleOrder')
                                <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <label class="flex items-center gap-2.5 text-sm text-slate-700">
                            <input type="checkbox" wire:model="isActive"
                                class="rounded border-slate-300 text-[#155E8A] focus:ring-[#155E8A]/30">
                            Active — visible within the course
                        </label>

                    </div>

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
                        <h3 class="text-white font-bold">Delete Module</h3>
                    </div>
                </div>

                <div class="p-5 text-sm text-slate-700 space-y-2">
                    <p>Are you sure you want to delete this module?</p>
                    <p class="font-semibold text-slate-900">{{ $deleteModuleName }}</p>
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
                            Delete Module
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
