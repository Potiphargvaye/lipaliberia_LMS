<?php

namespace App\Livewire\Admin\Students;

use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public Student $student;

    /*
    |--------------------------------------------------------------------------
    | Tabs — Overview, Personal, Employment, Education, Applications History,
    | Enrollment History, Documents. All history tabs are read-only; actioning
    | happens in the existing Admissions / Enrollment Management modules.
    |--------------------------------------------------------------------------
    */

    public string $activeTab = 'overview';

    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    /*
    |--------------------------------------------------------------------------
    | Mount
    |--------------------------------------------------------------------------
    */

    public function mount(Student $student)
    {
        $this->student = $student->load('user');

        // Lets the Index row's Edit icon deep-link straight into the modal
        // via admin.students.show + ?edit=1, without a new route.
        if (request()->query('edit') && auth()->user()->can('edit students')) {
            $this->openEditModal();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Student — full-screen modal. Personal, Employment, Education,
    | Emergency Contact, Documents, and Account fields are editable.
    | Student ID, Application, Enrollment, and audit fields are never
    | touched here.
    |--------------------------------------------------------------------------
    */

    public bool $showEditModal = false;

    // Personal
    public $name;
    public $gender;
    public $date_of_birth;
    public $nationality;
    public $county_of_residence;
    public $home_address;
    public $mobile_number;
    public $whatsapp_number;

    // Employment
    public $employment_status;
    public $employer_name;
    public $position_title;
    public $institution_contact_detail;
    public $institution_contact_info;
    public $years_experience;

    // Education
    public $highest_qualification;
    public $institution_attended;
    public $field_of_study;
    public $year_completed;

    // Emergency Contact
    public $emergency_contact_name;
    public $emergency_contact_phone;
    public $emergency_contact_relationship;
    public $requires_special_accommodation;
    public $special_accommodation_details;

    // Documents — only populated if the admin chooses to replace them
    public $passport_photo;
    public $academic_certificate;

    // Account (User)
    public $email;
    public $status;
    public $new_password;
    public $new_password_confirmation;

    public function openEditModal()
    {
        if (! auth()->user()->can('edit students')) {
            abort(403);
        }

        $this->student->loadMissing('user');

        $this->name = $this->student->name;
        $this->gender = $this->student->gender;
        $this->date_of_birth = optional($this->student->date_of_birth)->format('Y-m-d');
        $this->nationality = $this->student->nationality;
        $this->county_of_residence = $this->student->county_of_residence;
        $this->home_address = $this->student->home_address;
        $this->mobile_number = $this->student->mobile_number;
        $this->whatsapp_number = $this->student->whatsapp_number;

        $this->employment_status = $this->student->employment_status;
        $this->employer_name = $this->student->employer_name;
        $this->position_title = $this->student->position_title;
        $this->institution_contact_detail = $this->student->institution_contact_detail;
        $this->institution_contact_info = $this->student->institution_contact_info;
        $this->years_experience = $this->student->years_experience;

        $this->highest_qualification = $this->student->highest_qualification;
        $this->institution_attended = $this->student->institution_attended;
        $this->field_of_study = $this->student->field_of_study;
        $this->year_completed = $this->student->year_completed;

        $this->emergency_contact_name = $this->student->emergency_contact_name;
        $this->emergency_contact_phone = $this->student->emergency_contact_phone;
        $this->emergency_contact_relationship = $this->student->emergency_contact_relationship;
        $this->requires_special_accommodation = $this->student->requires_special_accommodation;
        $this->special_accommodation_details = $this->student->special_accommodation_details;

        $this->passport_photo = null;
        $this->academic_certificate = null;

        $this->email = $this->student->user?->email;
        $this->status = $this->student->user?->status;
        $this->new_password = '';
        $this->new_password_confirmation = '';

        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetErrorBag();
    }

    protected function editRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
            'county_of_residence' => 'required|string|max:255',
            'home_address' => 'required|string',
            'mobile_number' => ['required', 'regex:/^[0-9+\-\s()]+$/'],
            'whatsapp_number' => ['nullable', 'regex:/^[0-9+\-\s()]+$/'],

            'employment_status' => 'required|in:employed,self_employed,unemployed,student,other',
            'employer_name' => 'nullable|string|max:255',
            'position_title' => 'nullable|string|max:255',
            'institution_contact_detail' => 'nullable|string|max:255',
            'institution_contact_info' => 'nullable|string',
            'years_experience' => 'nullable|integer|min:0|max:80',

            'highest_qualification' => 'required|in:certificate,diploma,bachelor,master,doctorate,other',
            'institution_attended' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'year_completed' => 'nullable|integer|min:1950|max:' . now()->year,

            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:255',
            'emergency_contact_relationship' => 'required|string|max:255',
            'requires_special_accommodation' => 'boolean',
            'special_accommodation_details' => 'required_if:requires_special_accommodation,true|nullable|string',

            'passport_photo' => 'nullable|image|max:2048',
            'academic_certificate' => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',

            'email' => 'required|email|unique:users,email,' . $this->student->user_id,
            'status' => 'required|in:active,inactive',
            'new_password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function updateStudent()
    {
        if (! auth()->user()->can('edit students')) {
            abort(403);
        }

        $this->validate($this->editRules());

        $newPassportPath = $this->passport_photo
            ? $this->passport_photo->store('students/passports', 'public')
            : null;

        $newCertificatePath = $this->academic_certificate
            ? $this->academic_certificate->store('students/certificates', 'public')
            : null;

        try {
            DB::transaction(function () use ($newPassportPath, $newCertificatePath) {

                $this->student->loadMissing('user');
                $oldPassportPath = $this->student->passport_photo_path;
                $oldCertificatePath = $this->student->academic_certificate_path;

                $this->student->user?->update([
                    'email' => $this->email,
                    'status' => $this->status,
                    'password' => $this->new_password
                        ? Hash::make($this->new_password)
                        : $this->student->user->password,
                    'image' => $newPassportPath ?: $this->student->user->image,
                ]);

                $this->student->update([
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
                    'passport_photo_path' => $newPassportPath ?: $this->student->passport_photo_path,
                    'academic_certificate_path' => $newCertificatePath ?: $this->student->academic_certificate_path,
                    'emergency_contact_name' => $this->emergency_contact_name,
                    'emergency_contact_phone' => $this->emergency_contact_phone,
                    'emergency_contact_relationship' => $this->emergency_contact_relationship,
                    'requires_special_accommodation' => $this->requires_special_accommodation,
                    'special_accommodation_details' => $this->special_accommodation_details,
                ]);

                // Clean up replaced files only after the update succeeds.
                if ($newPassportPath && $oldPassportPath) {
                    Storage::disk('public')->delete($oldPassportPath);
                }
                if ($newCertificatePath && $oldCertificatePath) {
                    Storage::disk('public')->delete($oldCertificatePath);
                }
            });
        } catch (\Throwable $e) {
            if ($newPassportPath) {
                Storage::disk('public')->delete($newPassportPath);
            }
            if ($newCertificatePath) {
                Storage::disk('public')->delete($newCertificatePath);
            }

            report($e);

            $this->dispatch('notify', message: 'Something went wrong while saving. Please try again.', type: 'error');
            return;
        }

        $this->student->refresh()->load('user');
        $this->showEditModal = false;

        $this->dispatch('notify', message: 'Student profile updated successfully.', type: 'success');
    }

    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $applications = $this->student->applications()
            ->with(['course', 'intake'])
            ->latest()
            ->get();

        $enrollments = $this->student->enrollments()
            ->with(['course', 'intake'])
            ->latest()
            ->get();

        return view('livewire.admin.students.profile', [
            'applications' => $applications,
            'enrollments' => $enrollments,
            'canEdit' => auth()->user()->can('edit students'),
        ]);
    }
}
