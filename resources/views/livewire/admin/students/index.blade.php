<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')


    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Students</h1>
            <p class="text-slate-500 text-sm mt-1">
                One record per student — application and enrollment history live inside each profile.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('admin.admissions.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-[#155E8A] text-[#155E8A] font-semibold text-sm hover:bg-sky-50 transition-colors">
                <i class="fas fa-inbox text-xs"></i>
                View Admissions Queue
            </a>

            @can('create students')
                <a href="{{ route('admin.students.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[#F97316] hover:bg-orange-600 text-white font-semibold text-sm transition-colors">
                    <i class="fas fa-user-plus text-xs"></i>
                    Register Student
                </a>
            @endcan
        </div>
    </div>

    {{-- Search --}}
    <div class="bg-slate-50 border border-[#E2E8F0] rounded-xl p-3 sm:p-4">
        <div class="relative">
            <i class="fas fa-magnifying-glass text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input type="text" wire:model.live.debounce.350ms="search"
                placeholder="Search by name, email, mobile number, or Student ID..."
                class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[820px]">

                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Student ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Mobile</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Applications
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Enrollments</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($students as $student)
                        <tr wire:key="student-{{ $student->id }}" class="hover:bg-sky-50/60 transition-colors">

                            <td class="px-6 py-4 text-sm font-mono text-slate-600">
                                {{ $student->user?->registration_id ?? '—' }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $student->name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600 break-all">
                                {{ $student->user?->email ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $student->mobile_number }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex px-3 py-1 rounded-full bg-sky-100 text-[#155E8A] text-xs font-semibold">
                                    {{ $student->applications_count }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                                    {{ $student->enrollments_count }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">

                                    @if ($canView)
                                        <a href="{{ route('admin.students.show', $student) }}"
                                            class="h-9 w-9 rounded-lg bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] transition-colors flex items-center justify-center"
                                            title="View Profile">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                    @endif

                                    @if ($canEdit)
                                        <a href="{{ route('admin.students.show', $student) }}?edit=1"
                                            class="h-9 w-9 rounded-lg bg-orange-100 hover:bg-[#F97316] hover:text-white text-[#F97316] transition-colors flex items-center justify-center"
                                            title="Edit Student">
                                            <i class="fas fa-pen text-sm"></i>
                                        </a>
                                    @endif

                                    @if ($canDelete)
                                        <button wire:click="confirmDelete({{ $student->id }})"
                                            class="h-9 w-9 rounded-lg bg-red-100 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] transition-colors flex items-center justify-center"
                                            title="Delete">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    @endif

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <i class="fas fa-user-graduate text-5xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500 text-sm">
                                    @if ($search)
                                        No students found matching "<span
                                            class="font-semibold">{{ $search }}</span>".
                                    @else
                                        No students found.
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="bg-slate-50 px-4 sm:px-6 py-4 border-t border-[#E2E8F0]">
            {{ $students->links() }}
        </div>

    </div>

    {{-- Delete Confirmation Modal --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center px-3 z-50">

            <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md overflow-hidden">

                <div class="relative bg-[#B91C1C] px-6 py-5">
                    <h2 class="text-white text-lg font-bold">Delete Student</h2>
                </div>

                <div class="p-6 bg-[#F8FAFC]">
                    <p class="text-sm text-slate-600">
                        Are you sure you want to delete
                        <span class="font-semibold text-slate-800">{{ $deleteStudentName }}</span>?
                    </p>
                    <p class="text-xs text-slate-500 mt-2">
                        This permanently removes their login account, profile, and all associated
                        applications and enrollment history. This cannot be undone.
                    </p>
                </div>

                <div class="px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end gap-2">
                    <button wire:click="closeDeleteModal"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="deleteStudent"
                        class="px-5 py-2.5 rounded-lg bg-[#B91C1C] hover:bg-red-800 text-white font-semibold text-sm transition-colors">
                        Yes, Delete
                    </button>
                </div>

            </div>

        </div>
    @endif

</div>
