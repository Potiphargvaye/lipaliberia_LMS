<div class="space-y-5">

    @include('partials.notifications')

    {{-- Header --}}
    <div
        class="bg-white rounded-xl shadow p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div
                class="h-16 w-16 rounded-full bg-sky-100 flex items-center justify-center overflow-hidden ring-1 ring-slate-200">
                @if ($student->passport_photo_path)
                    <img src="{{ Storage::url($student->passport_photo_path) }}" class="h-full w-full object-cover">
                @else
                    <i class="fas fa-user-graduate text-2xl text-[#155E8A]"></i>
                @endif
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-800">{{ $student->name }}</h1>
                <p class="text-sm text-slate-500 font-mono">{{ $student->user?->registration_id ?? '—' }}</p>
                <p class="text-xs text-slate-400">{{ $student->user?->email ?? '—' }}</p>
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.students.index') }}"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-semibold text-sm hover:bg-slate-100 transition-colors">
                <i class="fas fa-arrow-left text-xs"></i> Back to Students
            </a>

            @if ($canEdit)
                <button wire:click="openEditModal"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[#F97316] hover:bg-orange-600 text-white font-semibold text-sm transition-colors">
                    <i class="fas fa-pen text-xs"></i> Edit Student
                </button>
            @endif
        </div>
    </div>

    {{-- Tabs --}}
    <div class="bg-white rounded-xl shadow p-4 sm:p-6 space-y-5">

        <div class="flex flex-wrap gap-2 border-b border-[#E2E8F0] pb-3">
            @foreach ([
        'overview' => ['Overview', 'fa-chart-pie'],
        'personal' => ['Personal', 'fa-id-card'],
        'employment' => ['Employment', 'fa-briefcase'],
        'education' => ['Education', 'fa-graduation-cap'],
        'applications' => ['Applications History', 'fa-file-lines'],
        'enrollments' => ['Enrollment History', 'fa-book-open'],
        'documents' => ['Documents', 'fa-folder-open'],
    ] as $key => [$label, $icon])
                <button type="button" wire:click="setTab('{{ $key }}')"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2
                        {{ $activeTab === $key ? 'bg-[#155E8A] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    <i class="fas {{ $icon }} text-xs"></i> {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Overview --}}
        @if ($activeTab === 'overview')
            @php
                $latestApplication = $student->latestApplication();
                $activeEnrollment = $student->activeEnrollment();
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-slate-50 rounded-xl p-4 border border-[#E2E8F0]">
                    <p class="text-xs text-slate-400 uppercase font-semibold">Mobile</p>
                    <p class="text-slate-800 font-medium mt-1">{{ $student->mobile_number }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-[#E2E8F0]">
                    <p class="text-xs text-slate-400 uppercase font-semibold">Total Applications</p>
                    <p class="text-slate-800 font-medium mt-1">{{ $applications->count() }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 border border-[#E2E8F0]">
                    <p class="text-xs text-slate-400 uppercase font-semibold">Total Enrollments</p>
                    <p class="text-slate-800 font-medium mt-1">{{ $enrollments->count() }}</p>
                </div>

                <div class="bg-sky-50 rounded-xl p-4 border border-sky-100 sm:col-span-1">
                    <p class="text-xs text-[#0B3A57] uppercase font-semibold">Latest Application</p>
                    @if ($latestApplication)
                        <p class="text-slate-800 font-medium mt-1">{{ $latestApplication->course->title ?? '—' }}</p>
                        <span
                            class="inline-flex mt-2 px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ match ($latestApplication->status) {
                                'pending' => 'bg-amber-100 text-amber-700',
                                'approved' => 'bg-green-100 text-green-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                default => 'bg-slate-200 text-slate-600',
                            } }}">
                            {{ ucfirst($latestApplication->status) }}
                        </span>
                    @else
                        <p class="text-slate-400 text-sm mt-1">No applications yet</p>
                    @endif
                </div>

                <div class="bg-sky-50 rounded-xl p-4 border border-sky-100 sm:col-span-2">
                    <p class="text-xs text-[#0B3A57] uppercase font-semibold">Active Enrollment</p>
                    @if ($activeEnrollment)
                        <p class="text-slate-800 font-medium mt-1">{{ $activeEnrollment->course->title ?? '—' }} —
                            {{ $activeEnrollment->intake->name ?? '—' }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <div class="w-24 h-2 rounded-full bg-white overflow-hidden">
                                <div class="h-full bg-[#155E8A]"
                                    style="width: {{ $activeEnrollment->progress_percentage ?? 0 }}%"></div>
                            </div>
                            <span
                                class="text-xs text-slate-500">{{ $activeEnrollment->progress_percentage ?? 0 }}%</span>
                        </div>
                    @else
                        <p class="text-slate-400 text-sm mt-1">No active enrollment</p>
                    @endif
                </div>
            </div>
        @endif

        {{-- Personal --}}
        @if ($activeTab === 'personal')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Gender</p>
                    <p class="text-slate-700 mt-1">{{ ucfirst($student->gender) }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Date of Birth</p>
                    <p class="text-slate-700 mt-1">{{ optional($student->date_of_birth)->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Nationality</p>
                    <p class="text-slate-700 mt-1">{{ $student->nationality }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">County of Residence</p>
                    <p class="text-slate-700 mt-1">{{ $student->county_of_residence }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs text-slate-400 uppercase font-semibold">Home Address</p>
                    <p class="text-slate-700 mt-1">{{ $student->home_address }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Mobile</p>
                    <p class="text-slate-700 mt-1">{{ $student->mobile_number }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">WhatsApp</p>
                    <p class="text-slate-700 mt-1">{{ $student->whatsapp_number ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Emergency Contact</p>
                    <p class="text-slate-700 mt-1">{{ $student->emergency_contact_name }}
                        ({{ $student->emergency_contact_relationship }})</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Emergency Phone</p>
                    <p class="text-slate-700 mt-1">{{ $student->emergency_contact_phone }}</p>
                </div>
                @if ($student->requires_special_accommodation)
                    <div class="sm:col-span-2 bg-amber-50 border border-amber-100 rounded-lg p-3">
                        <p class="text-xs text-amber-700 uppercase font-semibold">Special Accommodation</p>
                        <p class="text-slate-700 mt-1">{{ $student->special_accommodation_details }}</p>
                    </div>
                @endif
            </div>
        @endif

        {{-- Employment --}}
        @if ($activeTab === 'employment')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Employment Status</p>
                    <p class="text-slate-700 mt-1">{{ ucfirst(str_replace('_', ' ', $student->employment_status)) }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Years of Experience</p>
                    <p class="text-slate-700 mt-1">{{ $student->years_experience ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Employer</p>
                    <p class="text-slate-700 mt-1">{{ $student->employer_name ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Position</p>
                    <p class="text-slate-700 mt-1">{{ $student->position_title ?: '—' }}</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs text-slate-400 uppercase font-semibold">Employer Contact</p>
                    <p class="text-slate-700 mt-1">{{ $student->institution_contact_detail ?: '—' }}
                        {{ $student->institution_contact_info }}</p>
                </div>
            </div>
        @endif

        {{-- Education --}}
        @if ($activeTab === 'education')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Highest Qualification</p>
                    <p class="text-slate-700 mt-1">{{ ucfirst($student->highest_qualification) }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Year Completed</p>
                    <p class="text-slate-700 mt-1">{{ $student->year_completed ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Institution Attended</p>
                    <p class="text-slate-700 mt-1">{{ $student->institution_attended ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase font-semibold">Field of Study</p>
                    <p class="text-slate-700 mt-1">{{ $student->field_of_study ?: '—' }}</p>
                </div>
            </div>
        @endif

        {{-- Applications History (read-only) --}}
        @if ($activeTab === 'applications')
            <div class="space-y-3">
                <div class="flex justify-end">
                    <a href="{{ route('admin.admissions.index') }}"
                        class="text-xs font-semibold text-[#155E8A] hover:underline flex items-center gap-1">
                        Manage in Admissions Queue <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px] text-sm">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left">Application #</th>
                                <th class="px-4 py-3 text-left">Course</th>
                                <th class="px-4 py-3 text-left">Intake</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-left">Submitted</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($applications as $application)
                                <tr>
                                    <td class="px-4 py-3 font-mono text-xs text-slate-500">
                                        {{ $application->application_number }}</td>
                                    <td class="px-4 py-3">{{ $application->course->title ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $application->intake->name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold
                                            {{ match ($application->status) {
                                                'pending' => 'bg-amber-100 text-amber-700',
                                                'approved' => 'bg-green-100 text-green-700',
                                                'rejected' => 'bg-red-100 text-red-700',
                                                default => 'bg-slate-200 text-slate-600',
                                            } }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-500">
                                        {{ $application->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-slate-400">No applications
                                        yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Enrollment History (read-only) --}}
        @if ($activeTab === 'enrollments')
            <div class="space-y-3">
                <div class="flex justify-end">
                    <a href="{{ route('admin.enrollments.index') }}"
                        class="text-xs font-semibold text-[#155E8A] hover:underline flex items-center gap-1">
                        Manage in Enrollment Module <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px] text-sm">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-3 text-left">Course</th>
                                <th class="px-4 py-3 text-left">Intake</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Progress</th>
                                <th class="px-4 py-3 text-center">Certificate</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($enrollments as $enrollment)
                                <tr>
                                    <td class="px-4 py-3">{{ $enrollment->course->title ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $enrollment->intake->name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                            {{ ucfirst(str_replace('_', ' ', $enrollment->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">{{ $enrollment->progress_percentage ?? 0 }}%
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($enrollment->certificate_issued)
                                            <span class="text-green-600"><i class="fas fa-certificate"></i>
                                                Issued</span>
                                        @else
                                            <span class="text-slate-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-slate-400">No enrollments
                                        yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Documents (read-only, download links — re-upload happens via Edit Student) --}}
        @if ($activeTab === 'documents')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-slate-50 rounded-xl border border-[#E2E8F0] p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Passport Photo</p>
                        <p class="text-xs text-slate-400">
                            {{ $student->passport_photo_path ? 'Uploaded' : 'Not uploaded' }}</p>
                    </div>
                    @if ($student->passport_photo_path)
                        <a href="{{ Storage::url($student->passport_photo_path) }}" target="_blank"
                            class="px-3 py-1.5 rounded-lg bg-sky-100 text-[#155E8A] text-xs font-semibold hover:bg-[#155E8A] hover:text-white transition-colors">
                            <i class="fas fa-download text-xs"></i> Download
                        </a>
                    @endif
                </div>

                <div class="bg-slate-50 rounded-xl border border-[#E2E8F0] p-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-700">Academic Certificate</p>
                        <p class="text-xs text-slate-400">
                            {{ $student->academic_certificate_path ? 'Uploaded' : 'Not uploaded' }}</p>
                    </div>
                    @if ($student->academic_certificate_path)
                        <a href="{{ Storage::url($student->academic_certificate_path) }}" target="_blank"
                            class="px-3 py-1.5 rounded-lg bg-sky-100 text-[#155E8A] text-xs font-semibold hover:bg-[#155E8A] hover:text-white transition-colors">
                            <i class="fas fa-download text-xs"></i> Download
                        </a>
                    @endif
                </div>
            </div>
        @endif

    </div>



    {{-- Edit Student — full-screen modal --}}
    @if ($showEditModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-5xl max-h-[92vh] flex flex-col overflow-hidden">

                <div class="bg-[#155E8A] px-6 py-5 flex items-center justify-between shrink-0">
                    <h2 class="text-white text-lg font-bold">Edit Student — {{ $student->name }}</h2>
                    <button wire:click="closeEditModal" class="text-white/80 hover:text-white">
                        <i class="fas fa-xmark text-xl"></i>
                    </button>
                </div>

                <form wire:submit.prevent="updateStudent" class="overflow-y-auto p-6 space-y-8 bg-[#F8FAFC] flex-1">

                    <div
                        class="bg-sky-50 border border-sky-100 rounded-lg p-3 text-xs text-[#0B3A57] flex items-center gap-2">
                        <i class="fas fa-lock text-[10px]"></i>
                        Student ID ({{ $student->user?->registration_id }}), Applications, and Enrollment history
                        cannot be changed here — manage those from Admissions / Enrollment Management.
                    </div>

                    {{-- Personal --}}
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3 uppercase tracking-wide">Personal Information
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Full Name</label>
                                <input type="text" wire:model="name"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                                @error('name')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Gender</label>
                                <select wire:model="gender"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Date of Birth</label>
                                <input type="date" wire:model="date_of_birth"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Nationality</label>
                                <input type="text" wire:model="nationality"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">County of
                                    Residence</label>
                                <input type="text" wire:model="county_of_residence"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Home Address</label>
                                <textarea wire:model="home_address" rows="2"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Mobile Number</label>
                                <input type="text" wire:model="mobile_number"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                                @error('mobile_number')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">WhatsApp Number</label>
                                <input type="text" wire:model="whatsapp_number"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                        </div>
                    </div>

                    {{-- Employment --}}
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3 uppercase tracking-wide">Employment</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Employment
                                    Status</label>
                                <select wire:model="employment_status"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                                    <option value="employed">Employed</option>
                                    <option value="self_employed">Self-Employed</option>
                                    <option value="unemployed">Unemployed</option>
                                    <option value="student">Student</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Employer Name</label>
                                <input type="text" wire:model="employer_name"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Position / Title</label>
                                <input type="text" wire:model="position_title"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Employer Contact
                                    Person</label>
                                <input type="text" wire:model="institution_contact_detail"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Years of
                                    Experience</label>
                                <input type="number" min="0" wire:model="years_experience"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Employer Contact
                                    Info</label>
                                <textarea wire:model="institution_contact_info" rows="2"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Education --}}
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3 uppercase tracking-wide">Education</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Highest
                                    Qualification</label>
                                <select wire:model="highest_qualification"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                                    <option value="certificate">Certificate</option>
                                    <option value="diploma">Diploma</option>
                                    <option value="bachelor">Bachelor's Degree</option>
                                    <option value="master">Master's Degree</option>
                                    <option value="doctorate">Doctorate</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Year Completed</label>
                                <input type="number" wire:model="year_completed"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Institution
                                    Attended</label>
                                <input type="text" wire:model="institution_attended"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Field of Study</label>
                                <input type="text" wire:model="field_of_study"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                        </div>
                    </div>

                    {{-- Emergency Contact --}}
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3 uppercase tracking-wide">Emergency Contact
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Name</label>
                                <input type="text" wire:model="emergency_contact_name"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Phone</label>
                                <input type="text" wire:model="emergency_contact_phone"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Relationship</label>
                                <input type="text" wire:model="emergency_contact_relationship"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                            <div class="flex items-center gap-2 pt-6">
                                <input type="checkbox" wire:model.live="requires_special_accommodation"
                                    id="edit_accommodation"
                                    class="rounded border-slate-300 text-[#155E8A] focus:ring-[#155E8A]/30">
                                <label for="edit_accommodation" class="text-sm text-slate-700">Requires special
                                    accommodation</label>
                            </div>
                            @if ($requires_special_accommodation)
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-1">Accommodation
                                        Details</label>
                                    <textarea wire:model="special_accommodation_details" rows="2"
                                        class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]"></textarea>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Documents --}}
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3 uppercase tracking-wide">Documents <span
                                class="text-slate-400 font-normal normal-case">(leave blank to keep existing)</span>
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Replace Passport
                                    Photo</label>
                                <input type="file" wire:model="passport_photo" accept="image/*"
                                    class="w-full text-sm rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                                @error('passport_photo')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Replace Academic
                                    Certificate</label>
                                <input type="file" wire:model="academic_certificate" accept=".pdf,.jpg,.jpeg,.png"
                                    class="w-full text-sm rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                                @error('academic_certificate')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Account --}}
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3 uppercase tracking-wide">Account Details</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                                <input type="email" wire:model="email"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                                @error('email')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Account Status</label>
                                <select wire:model="status"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">New Password <span
                                        class="text-slate-400 font-normal">(optional)</span></label>
                                <input type="password" wire:model="new_password"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                                @error('new_password')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Confirm New
                                    Password</label>
                                <input type="password" wire:model="new_password_confirmation"
                                    class="w-full rounded-lg border-slate-300 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                            </div>
                        </div>
                    </div>

                </form>

                <div class="px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end gap-2 shrink-0">
                    <button wire:click="closeEditModal" type="button"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="updateStudent" wire:loading.attr="disabled" wire:target="updateStudent"
                        class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0B3A57] text-white font-semibold text-sm transition-colors disabled:opacity-60">
                        <span wire:loading.remove wire:target="updateStudent">Save Changes</span>
                        <span wire:loading wire:target="updateStudent">Saving...</span>
                    </button>
                </div>

            </div>
        </div>
    @endif

</div>
