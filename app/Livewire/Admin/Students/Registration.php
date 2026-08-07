<?php

namespace App\Livewire\Admin\Students;

use App\Models\Application;
use App\Models\Course;
use App\Models\Cohort;
use App\Models\Student;
use App\Models\User;
use App\Services\RegistrationIdService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Registration extends Component
{
    use WithFileUploads;

    /*
    |--------------------------------------------------------------------------
    | Wizard State
    |--------------------------------------------------------------------------
    */

    public int $currentStep = 1;
    public int $totalSteps = 5;

    public array $stepLabels = [
        1 => 'Personal Information',
        2 => 'Employment & Education',
        3 => 'Documents & Course',
        4 => 'Emergency & Account',
        5 => 'Application Details',
    ];

    /*
    |--------------------------------------------------------------------------
    | Section A — Personal Information
    |--------------------------------------------------------------------------
    */

    public $name = '';
    public $gender = '';
    public $date_of_birth = '';
    public $nationality = '';
    public $county_of_residence = '';
    public $home_address = '';
    public $mobile_number = '';
    public $whatsapp_number = '';

    /*
    |--------------------------------------------------------------------------
    | Section B — Employment
    |--------------------------------------------------------------------------
    */

    public $employment_status = '';
    public $employer_name = '';
    public $position_title = '';
    public $institution_contact_detail = '';
    public $institution_contact_info = '';
    public $years_experience = '';

    /*
    |--------------------------------------------------------------------------
    | Section C — Education
    |--------------------------------------------------------------------------
    */

    public $highest_qualification = '';
    public $institution_attended = '';
    public $field_of_study = '';
    public $year_completed = '';

    /*
    |--------------------------------------------------------------------------
    | Section D — Documents (temporary Livewire uploads)
    |--------------------------------------------------------------------------
    */

    public $passport_photo;
    public $academic_certificate;

    /*
    |--------------------------------------------------------------------------
    | Section E — Course, Cohort & Sponsorship
    |--------------------------------------------------------------------------
    */

    public $course_id = '';
    public $cohort_id = '';
    public $how_heard_about_us = '';
    public $sponsorship_type = '';
    public $sponsor_organization_name = '';
    public $requires_invoice = false;

    /*
    |--------------------------------------------------------------------------
    | Section F — Emergency Contact
    |--------------------------------------------------------------------------
    */

    public $emergency_contact_name = '';
    public $emergency_contact_phone = '';
    public $emergency_contact_relationship = '';
    public $requires_special_accommodation = false;
    public $special_accommodation_details = '';

    /*
    |--------------------------------------------------------------------------
    | Section G — Account Setup
    |--------------------------------------------------------------------------
    */

    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    /*
    |--------------------------------------------------------------------------
    | Section H — Application Details
    |--------------------------------------------------------------------------
    */

    public $interest_reason = '';
    public $skills_hoped_to_gain = '';
    public $previously_attended_lipa_training = false;

    /*
    |--------------------------------------------------------------------------
    | Lookups for the Course / Cohort dropdowns
    |--------------------------------------------------------------------------
    */

    public $courses = [];
    public $cohorts = [];

    public function mount()
    {
        if (! auth()->user()->can('create students')) {
            abort(403);
        }

        $this->courses = Course::where('is_active', true)
            ->orderBy('title')
            ->get();

        $this->cohorts = Cohort::where('is_active', true)->orderByDesc('start_date')->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Validation — one rule set per step. Condensed to 5 steps: rules for
    | previously-separate sections are simply merged into the step that now
    | contains them; no individual rule was changed.
    |--------------------------------------------------------------------------
    */

    protected function rulesForStep(int $step): array
    {
        return match ($step) {
            // Step 1: Personal Information (was step 1)
            1 => [
                'name' => 'required|string|max:255',
                'gender' => 'required|in:male,female,other',
                'date_of_birth' => 'required|date',
                'nationality' => 'required|string|max:255',
                'county_of_residence' => 'required|string|max:255',
                'home_address' => 'required|string',
                'mobile_number' => 'required|string|regex:/^[0-9+\-\s()]+$/|max:20',
                'whatsapp_number' => 'nullable|string|regex:/^[0-9+\-\s()]+$/|max:20',
            ],

            // Step 2: Employment & Education (was steps 2 + 3)
            2 => [
                'employment_status' => 'required|in:employed,self_employed,unemployed,student,other',
                'employer_name' => 'nullable|string|max:255',
                'position_title' => 'nullable|string|max:255',
                'institution_contact_detail' => 'nullable|string|max:255',
                'institution_contact_info' => 'nullable|string',
                'years_experience' => 'nullable|integer|min:0|max:80',

                'highest_qualification' => 'required|in:certificate,diploma,bachelor,master,doctorate,other',
                'institution_attended' => 'nullable|string|max:255',
                'field_of_study' => 'nullable|string|max:255',
                'year_completed' => 'nullable|integer|min:1950|max:' . (now()->year),
            ],

            // Step 3: Documents & Course (was steps 4 + 5)
            3 => [
                'passport_photo' => 'nullable|image|max:2048',
                'academic_certificate' => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',

                'course_id' => 'required|exists:courses,id',
                'cohort_id' => 'required|exists:cohorts,id',
                'how_heard_about_us' => 'nullable|string|max:255',
                'sponsorship_type' => 'required|in:self,employer,other',
                'sponsor_organization_name' => 'required_if:sponsorship_type,employer,other|nullable|string|max:255',
                'requires_invoice' => 'boolean',
            ],

            // Step 4: Emergency & Account (was steps 6 + 7)
            4 => [
                'emergency_contact_name' => 'required|string|max:255',
                'emergency_contact_phone' => 'required|string|max:255',
                'emergency_contact_relationship' => 'required|string|max:255',
                'requires_special_accommodation' => 'boolean',
                'special_accommodation_details' => 'required_if:requires_special_accommodation,true|nullable|string',

                'email' => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    'confirmed',
                ],
            ],

            // Step 5: Application Details (was step 8)
            5 => [
                'interest_reason' => 'required|string',
                'skills_hoped_to_gain' => 'nullable|string',
                'previously_attended_lipa_training' => 'boolean',
            ],

            default => [],
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */

    public function nextStep()
    {
        $this->validate($this->rulesForStep($this->currentStep));

        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep(int $step)
    {
        // Only allow jumping backward to a step already completed —
        // jumping forward still has to go through validation via Next.
        if ($step < $this->currentStep) {
            $this->currentStep = $step;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Submission — creates User, Student, and first Application together.
    | If anything fails, nothing is written (DB::transaction rollback).
    |--------------------------------------------------------------------------
    */

    public function submit()
    {
        if (! auth()->user()->can('create students')) {
            abort(403);
        }

        // Validate every section one last time in case the person jumped
        // backward and changed something after already passing a step.
        for ($step = 1; $step <= $this->totalSteps; $step++) {
            $this->validate($this->rulesForStep($step));
        }

        $passportPhotoPath = $this->passport_photo
            ? $this->passport_photo->store('students/passports', 'public')
            : null;

        $academicCertificatePath = $this->academic_certificate
            ? $this->academic_certificate->store('students/certificates', 'public')
            : null;

        try {
            $student = DB::transaction(function () use ($passportPhotoPath, $academicCertificatePath) {

                $registrationId = app(RegistrationIdService::class)->generate();

                $user = User::create([
                    'registration_id' => $registrationId,
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    // Passport photo doubles as the account's avatar, matching
                    // how Public Registration already handles $imagePath.
                    'image' => $passportPhotoPath,
                    'status' => 'active',
                    'created_by' => auth()->id(),
                ]);

                $user->assignRole('Student');

                $student = Student::create([
                    'user_id' => $user->id,
                    'name' => $this->name,
                    'gender' => $this->gender,
                    'date_of_birth' => $this->date_of_birth,
                    'nationality' => $this->nationality,
                    'county_of_residence' => $this->county_of_residence,
                    'home_address' => $this->home_address,
                    'mobile_number' => $this->mobile_number,
                    'whatsapp_number' => $this->whatsapp_number,
                    'employment_status' => $this->employment_status,
                    'employer_name' => $this->employer_name,
                    'position_title' => $this->position_title,
                    'institution_contact_detail' => $this->institution_contact_detail,
                    'institution_contact_info' => $this->institution_contact_info,
                    'years_experience' => $this->years_experience ?: null,
                    'highest_qualification' => $this->highest_qualification,
                    'institution_attended' => $this->institution_attended,
                    'field_of_study' => $this->field_of_study,
                    'year_completed' => $this->year_completed ?: null,
                    'passport_photo_path' => $passportPhotoPath,
                    'academic_certificate_path' => $academicCertificatePath,
                    'emergency_contact_name' => $this->emergency_contact_name,
                    'emergency_contact_phone' => $this->emergency_contact_phone,
                    'emergency_contact_relationship' => $this->emergency_contact_relationship,
                    'requires_special_accommodation' => $this->requires_special_accommodation,
                    'special_accommodation_details' => $this->special_accommodation_details,
                ]);

                Application::create([
                    'application_number' => Application::generateApplicationNumber(),
                    'student_id' => $student->id,
                    'course_id' => $this->course_id,
                    'cohort_id' => $this->cohort_id,
                    'status' => 'pending',
                    'how_heard_about_us' => $this->how_heard_about_us,
                    'sponsorship_type' => $this->sponsorship_type,
                    'sponsor_organization_name' => $this->sponsor_organization_name,
                    'requires_invoice' => $this->requires_invoice,
                    'interest_reason' => $this->interest_reason,
                    'skills_hoped_to_gain' => $this->skills_hoped_to_gain,
                    'previously_attended_lipa_training' => $this->previously_attended_lipa_training,
                ]);

                return $student;
            });
        } catch (\Throwable $e) {
            // Clean up any files we stored before the transaction failed,
            // so we don't leave orphaned uploads behind.
            if ($passportPhotoPath) {
                Storage::disk('public')->delete($passportPhotoPath);
            }
            if ($academicCertificatePath) {
                Storage::disk('public')->delete($academicCertificatePath);
            }

            report($e);

            session()->flash('error', 'Something went wrong while registering this student. Please try again.');

            return;
        }

        session()->flash('success', "Student registered successfully — Enrollment: Pending...: ");

        return redirect()->route('admin.students.index');
    }

    public function render()
    {
        return view('livewire.admin.students.registration');
    }
}
