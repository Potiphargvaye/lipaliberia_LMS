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
                        Learning Materials Management
                    </h1>

                    <p class="text-sky-100 text-sm mt-0.5">
                        Upload and organize learning resources within lesson modules.
                    </p>
                </div>

            </div>

            <div class="flex gap-2 shrink-0">

                <a href="{{ route('admin.modules.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white/10 border border-white/25 text-white font-semibold text-sm hover:bg-white/20 transition">

                    <i class="fas fa-arrow-left text-xs"></i>
                    Back to Modules

                </a>

                <button wire:click="openCreateModal"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white text-[#155E8A] font-semibold text-sm hover:bg-sky-50 transition">

                    <i class="fas fa-plus text-xs"></i>
                    New Material

                </button>

            </div>

        </div>

    </div>

    <!-- Search & Filters -->
    <div class="flex flex-col lg:flex-row gap-3">

        <div class="relative w-full lg:max-w-xs">

            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>

            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search materials..."
                class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

        </div>

        <div class="w-full lg:max-w-[220px]">
            <select wire:model.live="courseFilter"
                class="w-full py-2.5 px-3 rounded-lg border border-slate-300 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                <option value="">All Courses</option>
                @foreach ($allCourses as $course)
                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="w-full lg:max-w-[220px]">
            <select wire:model.live="moduleFilter"
                class="w-full py-2.5 px-3 rounded-lg border border-slate-300 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                <option value="">All Modules</option>
                @foreach ($filterModules as $module)
                    <option value="{{ $module->id }}">Module {{ $module->module_order }}: {{ $module->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="w-full lg:max-w-[200px]">
            <select wire:model.live="typeFilter"
                class="w-full py-2.5 px-3 rounded-lg border border-slate-300 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                <option value="">All Types</option>
                @foreach ($typeLabels as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="w-full lg:max-w-[160px]">
            <select wire:model.live="statusFilter"
                class="w-full py-2.5 px-3 rounded-lg border border-slate-300 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden overflow-x-auto">

        <table class="w-full text-sm min-w-[1100px]">

            <thead class="bg-[#F8FAFC] text-slate-500 text-xs uppercase">

                <tr>
                    <th class="px-4 py-3 text-left w-12">#</th>
                    <th class="px-4 py-3 text-left">Material Title</th>
                    <th class="px-4 py-3 text-left">Course</th>
                    <th class="px-4 py-3 text-left">Module</th>
                    <th class="px-4 py-3 text-left">Type</th>
                    <th class="px-4 py-3 text-left">File / Link</th>
                    <th class="px-4 py-3 text-left">Order</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-left">Uploaded By</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>

            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse($materials as $material)
                    <tr class="hover:bg-[#155E8A]/5 transition">

                        <td class="px-4 py-3 text-slate-400 font-medium">
                            {{ ($materials->currentPage() - 1) * $materials->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="font-semibold text-slate-800">{{ $material->title }}</div>
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $material->module->course->title ?? '—' }}
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            Module {{ $material->module->module_order ?? '?' }}: {{ $material->module->title ?? '—' }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-md bg-sky-50 text-[#155E8A] text-xs font-medium">
                                {{ $material->typeLabel() }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            @if ($material->isFileType() && $material->file_path)
                                <a href="{{ Storage::url($material->file_path) }}" target="_blank"
                                    class="text-[#155E8A] hover:underline text-xs font-medium">
                                    <i class="fas fa-file text-xs"></i> View File
                                </a>
                            @elseif ($material->type === 'external_link' && $material->external_url)
                                <a href="{{ $material->external_url }}" target="_blank" rel="noopener noreferrer"
                                    class="text-[#155E8A] hover:underline text-xs font-medium">
                                    <i class="fas fa-external-link-alt text-xs"></i> Open Link
                                </a>
                            @elseif ($material->type === 'text')
                                <span class="text-xs text-slate-400">Text content</span>
                            @else
                                <span class="text-xs text-slate-400">—</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $material->material_order }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $material->is_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $material->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-slate-600">
                            {{ $material->createdBy?->name ?? '—' }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">

                                <button wire:click="openPreviewModal({{ $material->id }})"
                                    class="h-8 w-8 rounded-md bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] flex items-center justify-center transition"
                                    title="Preview">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>

                                <button wire:click="openEditModal({{ $material->id }})"
                                    class="h-8 w-8 rounded-md bg-yellow-100 hover:bg-yellow-500 hover:text-white text-yellow-700 flex items-center justify-center transition"
                                    title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </button>

                                <button wire:click="confirmDelete({{ $material->id }})"
                                    class="h-8 w-8 rounded-md bg-[#B91C1C]/10 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] flex items-center justify-center transition"
                                    title="Delete">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-12 text-slate-500">
                            <i class="fas fa-book-open text-4xl text-slate-300 mb-3"></i>
                            <p>No learning materials found.</p>
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

    @if ($materials->hasPages())
        <div class="pt-2">
            {{ $materials->links() }}
        </div>
    @endif

    {{-- CREATE / EDIT MODAL --}}

    @if ($showModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">

            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden">

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
                                    {{ $editingId ? 'Edit Learning Material' : 'Create Learning Material' }}
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

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Course
                                </label>

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
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Module
                                </label>

                                <select wire:model="moduleId" @if (!$courseId) disabled @endif
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow disabled:bg-slate-100 disabled:cursor-not-allowed">
                                    <option value="">
                                        {{ $courseId ? 'Select a module...' : 'Select a course first' }}
                                    </option>
                                    @foreach ($availableModules as $module)
                                        <option value="{{ $module->id }}">
                                            Module {{ $module->module_order }}: {{ $module->title }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('moduleId')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Material Type
                            </label>

                            <select wire:model.live="type"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                                <option value="">Select a type...</option>
                                @foreach ($typeLabels as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>

                            @error('type')
                                <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Title
                            </label>

                            <input type="text" wire:model="title" placeholder="e.g. Introduction Video"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                            @error('title')
                                <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Dynamic field: file upload types --}}
                        @if (in_array($type, \App\Models\LearningMaterial::FILE_TYPES))
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    File
                                </label>

                                <input type="file" wire:model="file" accept="{{ $this->fileAccept() }}"
                                    class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-[#155E8A] file:text-white file:text-sm file:font-semibold hover:file:bg-[#0F4C81]">

                                <p class="mt-1 text-xs text-slate-400">{{ $this->fileSizeLabel() }}</p>

                                <div wire:loading wire:target="file" class="text-xs text-[#155E8A] mt-1">
                                    <i class="fas fa-spinner fa-spin"></i> Uploading...
                                </div>

                                @if ($existingImage = $existingFilePath)
                                    <p class="mt-1 text-xs text-slate-500">
                                        <i class="fas fa-paperclip"></i> Current file:
                                        <a href="{{ Storage::url($existingFilePath) }}" target="_blank"
                                            class="text-[#155E8A] hover:underline">view existing file</a>
                                        upload a new one to replace it.
                                    </p>
                                @endif

                                @error('file')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        {{-- Dynamic field: external link --}}
                        @if ($type === 'external_link')
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    External URL
                                </label>

                                <input type="url" wire:model="externalUrl" placeholder="https://..."
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('externalUrl')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        {{-- Dynamic field: text content --}}
                        @if ($type === 'text')
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Content
                                </label>

                                <textarea wire:model="content" rows="6" placeholder="Write the lesson content here..."
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>

                                @error('content')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Description
                                <span class="text-slate-400 font-normal">(Optional)</span>
                            </label>

                            <textarea wire:model="description" rows="2" placeholder="Short note about this material"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                    Material Order
                                </label>

                                <input type="number" min="1" wire:model="materialOrder" placeholder="e.g. 1"
                                    class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                @error('materialOrder')
                                    <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-end">
                                <label class="flex items-center gap-2.5 text-sm text-slate-700 pb-2.5">
                                    <input type="checkbox" wire:model="isActive"
                                        class="rounded border-slate-300 text-[#155E8A] focus:ring-[#155E8A]/30">
                                    Active visible within the module
                                </label>
                            </div>

                        </div>

                    </div>

                    <div class="bg-white border border-[#E2E8F0] rounded-xl px-5 py-4 flex justify-end gap-3">

                        <button type="button" wire:click="closeModal"
                            class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition">
                            Cancel
                        </button>

                        <button type="submit" wire:loading.attr="disabled" wire:target="save,file"
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

    {{-- PREVIEW MODAL --}}

    @if ($showPreviewModal && $previewMaterial)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">

            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden">

                <div class="relative bg-[#155E8A] px-6 py-5 shrink-0">

                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#B91C1C]"></div>

                    <div class="flex items-start justify-between gap-3">

                        <div>
                            <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold">
                                {{ $previewMaterial->module->course->title ?? '' }}
                                Module {{ $previewMaterial->module->module_order ?? '' }}
                            </p>

                            <h2 class="text-white text-lg font-bold">
                                {{ $previewMaterial->title }}
                            </h2>
                        </div>

                        <button wire:click="closePreviewModal"
                            class="h-10 w-10 rounded-lg bg-white/10 hover:bg-red-600 transition flex items-center justify-center text-white">
                            <i class="fas fa-times"></i>
                        </button>

                    </div>

                </div>

                <div class="flex-1 overflow-y-auto bg-[#F8FAFC] p-6 space-y-4">

                    @if ($previewMaterial->type === 'video' && $previewMaterial->file_path)
                        <video controls class="w-full rounded-lg border border-slate-200 bg-black">
                            <source src="{{ Storage::url($previewMaterial->file_path) }}">
                            Your browser does not support video playback.
                        </video>
                    @elseif ($previewMaterial->type === 'pdf' && $previewMaterial->file_path)
                        <iframe src="{{ Storage::url($previewMaterial->file_path) }}"
                            class="w-full h-[60vh] rounded-lg border border-slate-200"></iframe>
                    @elseif ($previewMaterial->type === 'text')
                        <div
                            class="bg-white rounded-xl border border-[#E2E8F0] p-5 text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                            {{ $previewMaterial->content }}
                        </div>
                    @elseif ($previewMaterial->type === 'external_link' && $previewMaterial->external_url)
                        <div class="bg-white rounded-xl border border-[#E2E8F0] p-5 text-center space-y-3">
                            <i class="fas fa-external-link-alt text-3xl text-[#155E8A]"></i>
                            <p class="text-sm text-slate-600 break-all">{{ $previewMaterial->external_url }}</p>
                            <a href="{{ $previewMaterial->external_url }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4C81] text-white text-sm font-semibold transition">
                                Open Link
                            </a>
                        </div>
                    @elseif ($previewMaterial->isFileType() && $previewMaterial->file_path)
                        <div class="bg-white rounded-xl border border-[#E2E8F0] p-5 text-center space-y-3">
                            <i class="fas fa-file-download text-3xl text-[#155E8A]"></i>
                            <p class="text-sm text-slate-600">{{ $previewMaterial->typeLabel() }} preview not
                                available in-browser.</p>
                            <a href="{{ Storage::url($previewMaterial->file_path) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4C81] text-white text-sm font-semibold transition">
                                <i class="fas fa-download"></i>
                                Download File
                            </a>
                        </div>
                    @else
                        <div class="text-center py-10 text-slate-400 text-sm">
                            No preview available for this material.
                        </div>
                    @endif

                    @if ($previewMaterial->description)
                        <div class="bg-white rounded-xl border border-[#E2E8F0] p-4">
                            <p class="text-xs font-semibold text-slate-500 uppercase mb-1">Description</p>
                            <p class="text-sm text-slate-700">{{ $previewMaterial->description }}</p>
                        </div>
                    @endif

                </div>

                <div class="bg-white border-t border-[#E2E8F0] px-6 py-4 flex justify-end shrink-0">
                    <button wire:click="closePreviewModal"
                        class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4C81] text-white text-sm font-semibold transition">
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
                        <h3 class="text-white font-bold">Delete Learning Material</h3>
                    </div>
                </div>

                <div class="p-5 text-sm text-slate-700 space-y-2">
                    <p>Are you sure you want to delete this learning material?</p>
                    <p class="font-semibold text-slate-900">{{ $deleteMaterialName }}</p>
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
                            Delete Material
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
