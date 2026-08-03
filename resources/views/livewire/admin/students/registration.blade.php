<div class="p-4 sm:p-8 bg-white rounded-2xl shadow-sm ring-1 ring-black/5 space-y-6" x-data="{}">

    @include('partials.notifications')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-5 border-b border-[#E2E8F0]">
        <div class="flex items-center gap-3">
            <div class="h-11 w-11 shrink-0 rounded-xl bg-sky-50 text-[#155E8A] flex items-center justify-center">
                <i class="fas fa-user-graduate text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-800">Register Student</h1>
                <p class="text-slate-500 text-xs sm:text-sm mt-0.5">
                    Creates the login account, profile, and first Application in one step.
                </p>
            </div>
        </div>

        <a href="{{ route('admin.students.index') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-semibold text-sm hover:border-[#155E8A] hover:text-[#155E8A] hover:bg-sky-50 transition-colors shrink-0">
            <i class="fas fa-arrow-left text-xs"></i>
            Back to Students
        </a>
    </div>

    {{-- Stepper --}}
    <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-4 sm:p-5 overflow-x-auto">
        <div class="flex items-center min-w-[860px]">
            @foreach ($stepLabels as $step => $label)
                <button type="button" wire:click="goToStep({{ $step }})" @disabled($step >= $currentStep)
                    class="flex flex-col items-center gap-1.5 flex-1 {{ $step < $currentStep ? 'cursor-pointer' : 'cursor-default' }}">
                    <div
                        class="h-9 w-9 sm:h-10 sm:w-10 rounded-full flex items-center justify-center text-xs font-bold border-2 transition-colors shadow-sm
                            @if ($step < $currentStep) bg-[#155E8A] border-[#155E8A] text-white
                            @elseif ($step === $currentStep) bg-white border-[#B91C1C] text-[#B91C1C] ring-4 ring-[#B91C1C]/10
                            @else bg-white border-slate-300 text-slate-400 @endif">
                        @if ($step < $currentStep)
                            <i class="fas fa-check text-[11px]"></i>
                        @else
                            {{ $step }}
                        @endif
                    </div>
                    <span
                        class="text-[11px] font-semibold text-center leading-tight
                            {{ $step === $currentStep ? 'text-[#155E8A]' : 'text-slate-400' }}">
                        {{ $label }}
                    </span>
                </button>
                @if (!$loop->last)
                    <div
                        class="h-0.5 flex-1 mx-1 rounded-full {{ $step < $currentStep ? 'bg-[#155E8A]' : 'bg-slate-200' }}">
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <form wire:submit.prevent="{{ $currentStep === $totalSteps ? 'submit' : 'nextStep' }}" class="space-y-6">

        {{-- Section A — Personal Information --}}
        @if ($currentStep === 1)
            <div>
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-8 w-8 rounded-lg bg-sky-50 text-[#155E8A] flex items-center justify-center">
                        <i class="fas fa-id-card text-sm"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wide text-[#155E8A]">Section A — Personal
                            Information</h2>
                        <p class="text-xs text-slate-400">Basic details about the applicant</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Full Name <span class="text-[#B91C1C]">*</span>
                        </label>
                        <input type="text" wire:model="name"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('name')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Gender <span class="text-[#B91C1C]">*</span>
                        </label>
                        <select wire:model="gender"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            <option value="">Select...</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        @error('gender')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Date of Birth <span class="text-[#B91C1C]">*</span>
                        </label>
                        <input type="date" wire:model="date_of_birth"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('date_of_birth')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Nationality <span class="text-[#B91C1C]">*</span>
                        </label>
                        <input type="text" wire:model="nationality"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('nationality')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            County of Residence <span class="text-[#B91C1C]">*</span>
                        </label>
                        <input type="text" wire:model="county_of_residence"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('county_of_residence')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Home Address <span class="text-[#B91C1C]">*</span>
                        </label>
                        <textarea wire:model="home_address" rows="2"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>
                        @error('home_address')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Mobile Number <span class="text-[#B91C1C]">*</span>
                        </label>
                        <input type="text" wire:model="mobile_number" placeholder="e.g. 0770123456"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('mobile_number')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">WhatsApp Number
                            <span class="text-slate-400 font-normal">(optional)</span></label>
                        <input type="text" wire:model="whatsapp_number"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('whatsapp_number')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        {{-- Section B — Employment --}}
        @if ($currentStep === 2)
            <div>
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-8 w-8 rounded-lg bg-sky-50 text-[#155E8A] flex items-center justify-center">
                        <i class="fas fa-briefcase text-sm"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wide text-[#155E8A]">Section B — Employment</h2>
                        <p class="text-xs text-slate-400">Current employment situation</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Employment Status <span class="text-[#B91C1C]">*</span>
                        </label>
                        <select wire:model="employment_status"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            <option value="">Select...</option>
                            <option value="employed">Employed</option>
                            <option value="self_employed">Self-Employed</option>
                            <option value="unemployed">Unemployed</option>
                            <option value="student">Student</option>
                            <option value="other">Other</option>
                        </select>
                        @error('employment_status')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Employer Name</label>
                        <input type="text" wire:model="employer_name"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Position / Title</label>
                        <input type="text" wire:model="position_title"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Employer Contact
                            Person</label>
                        <input type="text" wire:model="institution_contact_detail"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Years of Experience</label>
                        <input type="number" min="0" wire:model="years_experience"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Employer Contact Info
                            <span class="text-slate-400 font-normal">(phone/email/address)</span></label>
                        <textarea wire:model="institution_contact_info" rows="2"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>
                    </div>
                </div>
            </div>
        @endif

        {{-- Section C — Education --}}
        @if ($currentStep === 3)
            <div>
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-8 w-8 rounded-lg bg-sky-50 text-[#155E8A] flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-sm"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wide text-[#155E8A]">Section C — Education</h2>
                        <p class="text-xs text-slate-400">Academic background</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Highest Qualification <span class="text-[#B91C1C]">*</span>
                        </label>
                        <select wire:model="highest_qualification"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            <option value="">Select...</option>
                            <option value="certificate">Certificate</option>
                            <option value="diploma">Diploma</option>
                            <option value="bachelor">Bachelor's Degree</option>
                            <option value="master">Master's Degree</option>
                            <option value="doctorate">Doctorate</option>
                            <option value="other">Other</option>
                        </select>
                        @error('highest_qualification')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Year Completed</label>
                        <input type="number" wire:model="year_completed"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('year_completed')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Institution Attended</label>
                        <input type="text" wire:model="institution_attended"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Field of Study</label>
                        <input type="text" wire:model="field_of_study"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>
                </div>
            </div>
        @endif

        {{-- Section D — Documents --}}
        @if ($currentStep === 4)
            <div>
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-8 w-8 rounded-lg bg-sky-50 text-[#155E8A] flex items-center justify-center">
                        <i class="fas fa-file-upload text-sm"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wide text-[#155E8A]">Section D — Documents</h2>
                        <p class="text-xs text-slate-400">Photo and academic records</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-lg p-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Passport Photo</label>
                        <input type="file" wire:model="passport_photo" accept="image/*"
                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-sky-100 file:text-[#155E8A] file:font-semibold file:text-xs hover:file:bg-sky-200 file:cursor-pointer cursor-pointer">
                        <div wire:loading wire:target="passport_photo"
                            class="text-xs text-[#155E8A] mt-2 flex items-center gap-1">
                            <i class="fas fa-circle-notch fa-spin"></i> Uploading...
                        </div>
                        @if ($passport_photo)
                            <img src="{{ $passport_photo->temporaryUrl() }}"
                                class="mt-3 h-20 w-20 rounded-lg object-cover ring-2 ring-white shadow-sm">
                        @endif
                        @error('passport_photo')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-lg p-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Academic Certificate
                            <span class="text-slate-400 font-normal">(PDF or image)</span></label>
                        <input type="file" wire:model="academic_certificate" accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-sky-100 file:text-[#155E8A] file:font-semibold file:text-xs hover:file:bg-sky-200 file:cursor-pointer cursor-pointer">
                        <div wire:loading wire:target="academic_certificate"
                            class="text-xs text-[#155E8A] mt-2 flex items-center gap-1">
                            <i class="fas fa-circle-notch fa-spin"></i> Uploading...
                        </div>
                        @if ($academic_certificate)
                            <p
                                class="text-xs text-slate-600 mt-3 flex items-center gap-1.5 bg-white rounded-lg px-3 py-2 border border-[#E2E8F0]">
                                <i class="fas fa-file-lines text-[#155E8A]"></i>
                                {{ $academic_certificate->getClientOriginalName() }}
                            </p>
                        @endif
                        @error('academic_certificate')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        @endif

        {{-- Section E — Course, Intake & Sponsorship --}}
        @if ($currentStep === 5)
            <div>
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-8 w-8 rounded-lg bg-sky-50 text-[#155E8A] flex items-center justify-center">
                        <i class="fas fa-book-open text-sm"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wide text-[#155E8A]">Section E — Course &
                            Sponsorship</h2>
                        <p class="text-xs text-slate-400">Which course, intake, and how it's funded</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Course <span class="text-[#B91C1C]">*</span>
                        </label>
                        <select wire:model="course_id"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            <option value="">Select a course...</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Intake <span class="text-[#B91C1C]">*</span>
                        </label>
                        <select wire:model="intake_id"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            <option value="">Select a Cohort...</option>
                            @foreach ($intakes as $intake)
                                <option value="{{ $intake->id }}">{{ $intake->name }}</option>
                            @endforeach
                        </select>
                        @error('intake_id')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">How did they hear about
                            LIPA?</label>
                        <input type="text" wire:model="how_heard_about_us"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Sponsorship Type <span class="text-[#B91C1C]">*</span>
                        </label>
                        <select wire:model.live="sponsorship_type"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            <option value="">Select...</option>
                            <option value="self">Self-Sponsored</option>
                            <option value="employer">Employer-Sponsored</option>
                            <option value="other">Other</option>
                        </select>
                        @error('sponsorship_type')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    @if (in_array($sponsorship_type, ['employer', 'other']))
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Sponsor Organization Name <span class="text-[#B91C1C]">*</span>
                            </label>
                            <input type="text" wire:model="sponsor_organization_name"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            @error('sponsor_organization_name')
                                <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <div
                        class="sm:col-span-2 flex items-center gap-2.5 bg-[#F8FAFC] border border-[#E2E8F0] rounded-lg px-3.5 py-3">
                        <input type="checkbox" wire:model="requires_invoice" id="requires_invoice"
                            class="h-4 w-4 rounded border-slate-300 text-[#155E8A] focus:ring-[#155E8A]/30">
                        <label for="requires_invoice" class="text-sm text-slate-700">Requires an invoice</label>
                    </div>
                </div>
            </div>
        @endif

        {{-- Section F — Emergency Contact --}}
        @if ($currentStep === 6)
            <div>
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-8 w-8 rounded-lg bg-sky-50 text-[#155E8A] flex items-center justify-center">
                        <i class="fas fa-phone-volume text-sm"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wide text-[#155E8A]">Section F — Emergency
                            Contact</h2>
                        <p class="text-xs text-slate-400">Who to reach in case of emergency</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Emergency Contact Name <span class="text-[#B91C1C]">*</span>
                        </label>
                        <input type="text" wire:model="emergency_contact_name"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('emergency_contact_name')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Emergency Contact Phone <span class="text-[#B91C1C]">*</span>
                        </label>
                        <input type="text" wire:model="emergency_contact_phone"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('emergency_contact_phone')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Relationship <span class="text-[#B91C1C]">*</span>
                        </label>
                        <input type="text" wire:model="emergency_contact_relationship"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('emergency_contact_relationship')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div
                        class="sm:col-span-2 flex items-center gap-2.5 bg-[#F8FAFC] border border-[#E2E8F0] rounded-lg px-3.5 py-3">
                        <input type="checkbox" wire:model.live="requires_special_accommodation"
                            id="requires_accommodation"
                            class="h-4 w-4 rounded border-slate-300 text-[#155E8A] focus:ring-[#155E8A]/30">
                        <label for="requires_accommodation" class="text-sm text-slate-700">Requires special
                            accommodation</label>
                    </div>

                    @if ($requires_special_accommodation)
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Accommodation
                                Details</label>
                            <textarea wire:model="special_accommodation_details" rows="2"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>
                            @error('special_accommodation_details')
                                <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Section G — Account Setup --}}
        @if ($currentStep === 7)
            <div>
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-8 w-8 rounded-lg bg-sky-50 text-[#155E8A] flex items-center justify-center">
                        <i class="fas fa-key text-sm"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wide text-[#155E8A]">Section G — Account Setup
                        </h2>
                        <p class="text-xs text-slate-400">Login credentials for the student</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div
                        class="sm:col-span-2 flex items-start gap-2.5 bg-sky-50 border border-sky-100 rounded-lg p-3.5 text-xs text-[#0B3A57]">
                        <i class="fas fa-circle-info mt-0.5 text-[#155E8A]"></i>
                        <span>This creates the student's login. A Student ID (e.g. LIPA/STU/{{ now()->year }}/0001)
                            is
                            generated automatically on save.</span>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Email Address <span class="text-[#B91C1C]">*</span>
                        </label>
                        <input type="email" wire:model="email"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('email')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div></div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Password <span class="text-[#B91C1C]">*</span>
                        </label>
                        <input type="password" wire:model="password"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('password')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm Password</label>
                        <input type="password" wire:model="password_confirmation"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>
                </div>
            </div>
        @endif

        {{-- Section H — Application Details --}}
        @if ($currentStep === 8)
            <div>
                <div class="flex items-center gap-2 mb-5">
                    <span class="h-8 w-8 rounded-lg bg-sky-50 text-[#155E8A] flex items-center justify-center">
                        <i class="fas fa-clipboard-list text-sm"></i>
                    </span>
                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wide text-[#155E8A]">Section H — Training Needs
                            Assessment</h2>
                        <p class="text-xs text-slate-400">Interests and prior training</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Why are they interested in
                            this
                            course?</label>
                        <textarea wire:model="interest_reason" rows="3"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>
                        @error('interest_reason')
                            <p class="text-xs text-[#B91C1C] mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Skills hoped to gain</label>
                        <textarea wire:model="skills_hoped_to_gain" rows="3"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>
                    </div>

                    <div class="flex items-center gap-2.5 bg-[#F8FAFC] border border-[#E2E8F0] rounded-lg px-3.5 py-3">
                        <input type="checkbox" wire:model="previously_attended_lipa_training"
                            id="previously_attended"
                            class="h-4 w-4 rounded border-slate-300 text-[#155E8A] focus:ring-[#155E8A]/30">
                        <label for="previously_attended" class="text-sm text-slate-700">Previously attended LIPA
                            training</label>
                    </div>
                </div>
            </div>
        @endif

        {{-- Navigation --}}
        <div class="flex items-center justify-between pt-5 border-t border-[#E2E8F0]">
            <button type="button" wire:click="previousStep"
                class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-semibold text-sm hover:bg-slate-100 transition-colors {{ $currentStep === 1 ? 'invisible' : '' }}">
                <i class="fas fa-arrow-left text-xs mr-1"></i> Back
            </button>

            <span class="text-xs font-medium text-slate-400">Step {{ $currentStep }} of {{ $totalSteps }}</span>

            @if ($currentStep < $totalSteps)
                <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm transition-colors shadow-sm">
                    Next <i class="fas fa-arrow-right text-xs ml-1"></i>
                </button>
            @else
                <button type="submit" wire:loading.attr="disabled" wire:target="submit"
                    class="px-5 py-2.5 rounded-lg bg-[#B91C1C] hover:bg-red-800 text-white font-semibold text-sm transition-colors shadow-sm disabled:opacity-60">
                    <span wire:loading.remove wire:target="submit">
                        <i class="fas fa-check text-xs mr-1"></i> Complete Registration
                    </span>
                    <span wire:loading wire:target="submit">Saving...</span>
                </button>
            @endif
        </div>

    </form>

</div>
