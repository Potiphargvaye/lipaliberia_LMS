<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Admissions</h1>
            <p class="text-slate-500 text-sm mt-1">
                Review and process student applications.
            </p>
        </div>

        <a href="{{ route('admin.students.index') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-[#155E8A] text-[#155E8A] font-semibold text-sm hover:bg-sky-50 transition-colors">
            <i class="fas fa-user-graduate text-xs"></i>
            View Students
        </a>
    </div>

    {{-- Status Tabs --}}
    <div class="flex flex-wrap gap-2 border-b border-[#E2E8F0] pb-3 overflow-x-auto">

        @php
            $tabs = [
                'pending' => ['label' => 'Pending', 'icon' => 'fa-hourglass-half'],
                'approved' => ['label' => 'Approved', 'icon' => 'fa-circle-check'],
                'rejected' => ['label' => 'Rejected', 'icon' => 'fa-circle-xmark'],
                'cancelled' => ['label' => 'Cancelled', 'icon' => 'fa-ban'],
            ];
        @endphp

        @foreach ($tabs as $key => $tab)
            <button wire:click="$set('status', '{{ $key }}')"
                class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold transition-all whitespace-nowrap
                    {{ $status === $key ? 'bg-[#155E8A] text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">

                <i class="fas {{ $tab['icon'] }} text-xs"></i>
                <span>{{ $tab['label'] }}</span>

                <span
                    class="text-xs px-2 py-0.5 rounded-full font-bold
                    {{ $status === $key ? 'bg-white text-[#155E8A]' : 'bg-slate-300 text-slate-700' }}">
                    {{ $statusCounts[$key] ?? 0 }}
                </span>

            </button>
        @endforeach

    </div>

    {{-- Search --}}
    <div class="bg-slate-50 border border-[#E2E8F0] rounded-xl p-3 sm:p-4">
        <div class="relative">
            <i class="fas fa-magnifying-glass text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input type="text" wire:model.live.debounce.350ms="search"
                placeholder="Search by application number or student name..."
                class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[860px]">

                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Application #</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Student</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Course</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Cohort</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Submitted</th>
                        @if ($canApprove)
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Actions</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($applications as $application)

                        <tr wire:key="application-{{ $application->id }}" class="hover:bg-sky-50/60 transition-colors">

                            <td class="px-6 py-4 text-sm font-mono text-slate-600">
                                {{ $application->application_number }}
                            </td>

                            <td class="px-6 py-4">
                                <a href="{{ route('admin.students.show', $application->student_id) }}"
                                    class="font-semibold text-slate-800 hover:text-[#155E8A] transition-colors">
                                    {{ $application->student?->name }}
                                </a>
                                <p class="text-xs text-slate-400">{{ $application->student?->user?->email }}</p>
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $application->course?->title }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $application->intake?->name }}
                            </td>

                            <td class="px-6 py-4 text-center text-sm text-slate-500">
                                {{ $application->created_at->format('d M Y') }}
                            </td>

                            @if ($canApprove)
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-1.5 flex-wrap">

                                        @if ($application->status === 'pending')
                                            <button wire:click="approve({{ $application->id }})"
                                                wire:confirm="Approve this application and enroll the student?"
                                                class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-semibold">
                                                Approve
                                            </button>
                                            <button wire:click="confirmReject({{ $application->id }})"
                                                class="px-3 py-1.5 bg-[#B91C1C] hover:bg-red-800 text-white rounded text-xs font-semibold">
                                                Reject
                                            </button>
                                            <button wire:click="cancel({{ $application->id }})"
                                                wire:confirm="Cancel this application?"
                                                class="px-3 py-1.5 border border-slate-300 text-slate-600 hover:bg-slate-100 rounded text-xs font-semibold">
                                                Cancel
                                            </button>
                                        @elseif($application->status === 'approved')
                                            <button wire:click="cancel({{ $application->id }})"
                                                wire:confirm="Cancel this application?"
                                                class="px-3 py-1.5 border border-slate-300 text-slate-600 hover:bg-slate-100 rounded text-xs font-semibold">
                                                Cancel
                                            </button>
                                        @else
                                            <span class="text-xs text-slate-400">No actions</span>
                                        @endif

                                    </div>
                                </td>
                            @endif

                        </tr>

                    @empty

                        <tr>
                            <td colspan="{{ $canApprove ? 6 : 5 }}" class="text-center py-16">
                                <i class="fas fa-inbox text-5xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500 text-sm">
                                    No {{ $status }} applications found.
                                </p>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="bg-slate-50 px-4 sm:px-6 py-4 border-t border-[#E2E8F0]">
            {{ $applications->links() }}
        </div>

    </div>

    {{-- Reject Confirmation Modal --}}
    @if ($showRejectModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center px-3 z-50">

            <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md overflow-hidden">

                <div class="relative bg-[#B91C1C] px-6 py-5">
                    <h2 class="text-white text-lg font-bold">Reject Application</h2>
                </div>

                <div class="p-6 bg-[#F8FAFC]">
                    <label class="block mb-1.5 text-xs font-semibold text-slate-600">
                        Reason for Rejection <span class="text-[#B91C1C]">*</span>
                    </label>
                    <textarea wire:model="rejectReason" rows="3" placeholder="Explain why this application is being rejected..."
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#B91C1C]/30 focus:border-[#B91C1C] transition-shadow"></textarea>
                    @error('rejectReason')
                        <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end gap-2">
                    <button wire:click="closeRejectModal"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="rejectApplication"
                        class="px-5 py-2.5 rounded-lg bg-[#B91C1C] hover:bg-red-800 text-white font-semibold text-sm transition-colors">
                        Confirm Rejection
                    </button>
                </div>

            </div>

        </div>
    @endif

</div>
