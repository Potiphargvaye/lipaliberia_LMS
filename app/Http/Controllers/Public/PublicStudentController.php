<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use App\Services\RegistrationIdService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PublicStudentController extends Controller
{
    public function __construct(protected RegistrationIdService $registrationIdService) {}

    public function create()
    {
        $courses = Course::where('is_active', true)->orderBy('title')->get();
        $cohorts = Cohort::where('is_active', true)->orderBy('sort_order')->orderBy('start_date')->get();

        return view('public.registration-form', compact('courses', 'cohorts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Section A - Personal Information
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
            'county_of_residence' => 'required|string|max:255',
            'home_address' => 'required|string',
            'mobile_number' => 'required|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',

            // Section B - Employment
            'employment_status' => 'required|in:employed,self_employed,unemployed,student,other',
            'employer_name' => 'nullable|string|max:255',
            'position_title' => 'nullable|string|max:255',
            'institution_contact_detail' => 'nullable|string|max:255',
            'institution_contact_info' => 'nullable|string',
            'years_experience' => 'nullable|integer|min:0',

            // Section C - Education
            'highest_qualification' => 'required|in:certificate,diploma,bachelor,master,doctorate,other',
            'institution_attended' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'year_completed' => 'nullable|integer',

            // Section D - Documents
            'passport_photo' => 'nullable|image|max:2048',
            'academic_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',

            // Section E - Course, Intake & Sponsorship
            'course_id' => 'required|exists:courses,id',
            'cohort_id' => 'required|exists:cohorts,id',
            'how_heard_about_us' => 'nullable|string|max:255',
            'sponsorship_type' => 'required|in:self,employer,other',
            'sponsor_organization_name' => 'required_if:sponsorship_type,employer,other|nullable|string|max:255',
            'requires_invoice' => 'nullable|boolean',

            // Section F - Emergency Contact
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'emergency_contact_relationship' => 'required|string|max:255',
            'requires_special_accommodation' => 'nullable|boolean',
            'special_accommodation_details' => 'nullable|string',

            // Section G - Account Setup
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',

            // Section H - Training Needs Assessment
            'interest_reason' => 'nullable|string',
            'skills_hoped_to_gain' => 'nullable|string',
            'previously_attended_lipa_training' => 'nullable|boolean',
        ]);

        $student = DB::transaction(function () use ($request, $validated) {

            // Same shared service used by Admin Registration — one source
            // of truth for the ID format/algorithm, per our architecture.
            $registrationId = $this->registrationIdService->generate();

            $user = User::create([
                'registration_id' => $registrationId,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'status' => 'active',
            ]);

            $user->assignRole('Student');

            $passportPhotoPath = $request->hasFile('passport_photo')
                ? $request->file('passport_photo')->store('students/photos', 'public')
                : null;

            $academicCertificatePath = $request->hasFile('academic_certificate')
                ? $request->file('academic_certificate')->store('students/certificates', 'public')
                : null;

            $student = Student::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'nationality' => $validated['nationality'],
                'county_of_residence' => $validated['county_of_residence'],
                'home_address' => $validated['home_address'],
                'mobile_number' => $validated['mobile_number'],
                'whatsapp_number' => $validated['whatsapp_number'] ?? null,
                'employment_status' => $validated['employment_status'],
                'employer_name' => $validated['employer_name'] ?? null,
                'position_title' => $validated['position_title'] ?? null,
                'institution_contact_detail' => $validated['institution_contact_detail'] ?? null,
                'institution_contact_info' => $validated['institution_contact_info'] ?? null,
                'years_experience' => $validated['years_experience'] ?? null,
                'highest_qualification' => $validated['highest_qualification'],
                'institution_attended' => $validated['institution_attended'] ?? null,
                'field_of_study' => $validated['field_of_study'] ?? null,
                'year_completed' => $validated['year_completed'] ?? null,
                'passport_photo_path' => $passportPhotoPath,
                'academic_certificate_path' => $academicCertificatePath,
                'emergency_contact_name' => $validated['emergency_contact_name'],
                'emergency_contact_phone' => $validated['emergency_contact_phone'],
                'emergency_contact_relationship' => $validated['emergency_contact_relationship'],
                'requires_special_accommodation' => $request->boolean('requires_special_accommodation'),
                'special_accommodation_details' => $validated['special_accommodation_details'] ?? null,
            ]);

            $applicationNumber = 'APP/' . now()->year . '/' . str_pad(
                Application::whereYear('created_at', now()->year)->count() + 1,
                5,
                '0',
                STR_PAD_LEFT
            );

            Application::create([
                'application_number' => $applicationNumber,
                'student_id' => $student->id,
                'course_id' => $validated['course_id'],
                'cohort_id' => $validated['cohort_id'],
                'status' => 'pending',
                'how_heard_about_us' => $validated['how_heard_about_us'] ?? null,
                'sponsorship_type' => $validated['sponsorship_type'],
                'sponsor_organization_name' => $validated['sponsor_organization_name'] ?? null,
                'requires_invoice' => $request->boolean('requires_invoice'),
                'interest_reason' => $validated['interest_reason'] ?? null,
                'skills_hoped_to_gain' => $validated['skills_hoped_to_gain'] ?? null,
                'previously_attended_lipa_training' => $request->boolean('previously_attended_lipa_training'),
            ]);

            return $student;
        });

        // Business rule: login is never gated by application approval —
        // the applicant is logged in immediately, and the pending status
        // is surfaced on their dashboard instead.
        Auth::login($student->user);
        $request->session()->regenerate();

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Registration completed successfully.',
                'redirect' => route('public.students.create'),
            ]);
        }

        return redirect()
            ->route('public.students.create')
            ->with('success', 'Your application has been submitted successfully.');
    }
}
