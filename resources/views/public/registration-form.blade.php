<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Student Registration - Liberia Institute of Public Administration</title>
    <meta name="description" content="Register for a course at the Liberia Institute of Public Administration">

    <link rel="icon" type="image/png" href="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            background-color: #f4f7fb;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
        }

        .lipa-registration-page {
            min-height: 100vh;
            padding-bottom: 4rem;
        }

        /* ================= BRANDED PAGE HEADER ================= */
        .lipa-page-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #1e6794;
            padding: 1.75rem 0 2rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
        }

        .lipa-page-header::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 4px;
            background-color: #B91C1C;
        }

        .lipa-page-header-inner {
            display: flex;
            align-items: center;
            gap: 1rem;
            max-width: 850px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .lipa-page-header-logo {
            flex-shrink: 0;
            height: 58px;
            width: 58px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px;
        }

        .lipa-page-header-logo img {
            height: 100%;
            width: 100%;
            object-fit: contain;
        }

        .lipa-page-header-org {
            color: #bfe3ff;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin: 0 0 0.15rem;
        }

        .lipa-page-header-title {
            color: #ffffff;
            font-size: 1.35rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.25;
        }

        .lipa-page-header-sub {
            color: #cfe9fb;
            font-size: 0.85rem;
            margin: 0.2rem 0 0;
        }

        /* ---- Page section ---- */
        .lipa-reg-section {
            max-width: 850px;
            width: 100%;
            margin: 0 auto;
            padding: 0 15px 2rem;
        }

        .lipa-card {
            border-radius: 16px;
            border: none;
            background-color: #ffffff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
        }

        .lipa-progress {
            height: 8px;
            border-radius: 6px;
            background-color: #eef2f6;
            overflow: hidden;
        }

        .lipa-progress-bar {
            background-color: #155E8A;
            transition: width 0.3s ease;
        }

        .lipa-step-heading {
            color: #155E8A;
            font-size: 1.05rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .03em;
            margin-bottom: 0.15rem;
        }

        .lipa-step-heading i {
            margin-right: 0.5rem;
        }

        .lipa-step-sub {
            color: #94a3b8;
            font-size: 0.82rem;
            margin-bottom: 1.25rem;
        }

        .form-step {
            display: none;
            animation: lipaFadeIn 0.35s ease-in-out;
        }

        .form-step.active {
            display: block;
        }

        @keyframes lipaFadeIn {
            0% {
                opacity: 0;
                transform: translateY(8px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #334155;
            margin-bottom: 0.35rem;
            display: block;
        }

        input.form-control-lg,
        select.form-control-lg,
        textarea.form-control-lg {
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            padding: 0.65rem 0.9rem;
            font-size: 0.9rem;
            color: #1e293b;
            background-color: #ffffff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            transition: border-color .15s, box-shadow .15s;
            width: 100%;
            height: auto;
        }

        input.form-control-lg:focus,
        select.form-control-lg:focus,
        textarea.form-control-lg:focus {
            border-color: #155E8A;
            box-shadow: 0 0 0 3px rgba(21, 94, 138, 0.15);
            outline: none;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .lipa-file-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem;
            height: 100%;
        }

        .lipa-photo-preview {
            margin-top: 0.75rem;
            height: 70px;
            width: 70px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
        }

        .lipa-file-name {
            font-size: 0.8rem;
            color: #475569;
            margin-top: 0.75rem;
            margin-bottom: 0;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
        }

        .lipa-file-name i {
            color: #155E8A;
            margin-right: 0.35rem;
        }

        .lipa-check {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.7rem 0.9rem;
        }

        .lipa-check input {
            width: 1rem;
            height: 1rem;
            accent-color: #155E8A;
        }

        .lipa-check label {
            margin: 0;
            font-size: 0.875rem;
            color: #334155;
        }

        .lipa-info-box {
            display: flex;
            gap: 0.6rem;
            align-items: flex-start;
            background: #e0f2fe;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 0.85rem 1rem;
            font-size: 0.8rem;
            color: #0b3a57;
        }

        .lipa-info-box i {
            color: #155E8A;
            margin-top: 0.15rem;
        }

        .lipa-review-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1rem 1.25rem;
        }

        .lipa-review-box .lipa-review-row {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.875rem;
        }

        .lipa-review-box .lipa-review-row:last-child {
            border-bottom: none;
        }

        .lipa-review-box .lipa-review-label {
            color: #64748b;
        }

        .lipa-review-box .lipa-review-value {
            font-weight: 600;
            color: #1e293b;
            text-align: right;
        }

        .lipa-btn-primary {
            background-color: #155E8A;
            border-color: #155E8A;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.6rem 1.3rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .lipa-btn-primary:hover {
            background-color: #0F4A6E;
            border-color: #0F4A6E;
            color: #fff;
        }

        .lipa-btn-primary:disabled,
        .lipa-btn-primary.is-loading {
            opacity: 0.75;
            cursor: not-allowed;
        }

        .lipa-btn-submit {
            background-color: #B91C1C;
            border-color: #B91C1C;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.6rem 1.3rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .lipa-btn-submit:hover {
            background-color: #991515;
            border-color: #991515;
            color: #fff;
        }

        .lipa-btn-submit:disabled,
        .lipa-btn-submit.is-loading {
            opacity: 0.75;
            cursor: not-allowed;
        }

        .lipa-btn-outline {
            background-color: transparent;
            border: 1px solid #cbd5e1;
            color: #334155;
            font-weight: 600;
            border-radius: 8px;
            padding: 0.6rem 1.3rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .lipa-btn-outline:hover {
            background-color: #f1f5f9;
            color: #334155;
        }

        .lipa-spinner {
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-top-color: #fff;
            border-radius: 50%;
            display: inline-block;
            animation: lipaSpin 0.7s linear infinite;
        }

        @keyframes lipaSpin {
            to {
                transform: rotate(360deg);
            }
        }

        .lipa-success-card {
            max-width: 480px;
            margin: 2rem auto 0 auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .lipa-success-icon {
            height: 64px;
            width: 64px;
            border-radius: 50%;
            background: #dcfce7;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.1rem auto;
            font-size: 1.5rem;
        }

        .lipa-success-card h2 {
            color: #0F4A6E;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .lipa-success-card p {
            color: #64748b;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .lipa-success-actions {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        .lipa-success-actions .lipa-btn-primary {
            width: auto;
            padding: 0.6rem 1.75rem;
        }

        @media (max-width: 767px) {

            .lipa-page-header {
                padding: 1.25rem 0 1.5rem;
                margin-bottom: 1.75rem;
            }

            .lipa-page-header-inner {
                gap: 0.75rem;
            }

            .lipa-page-header-logo {
                height: 46px;
                width: 46px;
                padding: 6px;
            }

            .lipa-page-header-title {
                font-size: 1.05rem;
            }

            .lipa-page-header-sub {
                font-size: 0.75rem;
            }

            .lipa-page-header-org {
                font-size: 0.62rem;
            }

            input.form-control-lg,
            select.form-control-lg,
            textarea.form-control-lg {
                font-size: 0.85rem;
            }

            .lipa-card {
                padding: 1.25rem;
                border-radius: 12px;
            }

            .lipa-step-heading {
                font-size: 0.95rem;
            }

            .form-step button {
                width: 100%;
                margin-top: 0.5rem !important;
            }

            .form-step .row .col-md-6,
            .form-step .row .col-md-4 {
                margin-bottom: 0.75rem;
            }

            .lipa-review-box .lipa-review-row {
                flex-direction: column;
                gap: 0.2rem;
            }

            .lipa-review-box .lipa-review-value {
                text-align: left;
            }

            .lipa-success-card {
                padding: 1.75rem 1.25rem;
                margin: 1rem auto 0;
                border-radius: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="lipa-registration-page">

        {{-- ================= LIPA BRANDED PAGE HEADER ================= --}}
        <div class="lipa-page-header">
            <div class="lipa-page-header-inner">
                <div class="lipa-page-header-logo">
                    <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}" alt="LIPA Logo">
                </div>
                <div>
                    <p class="lipa-page-header-org">Liberia Institute of Public Administration</p>
                    <h1 class="lipa-page-header-title">Student Registration</h1>
                    <p class="lipa-page-header-sub">Course Application &amp; Enrollment</p>
                </div>
            </div>
        </div>

        <section class="lipa-reg-section">

            @if (session('success'))

                {{-- ================= SUCCESS CARD ================= --}}
                <div class="lipa-success-card">
                    <div class="lipa-success-icon"><i class="fas fa-check"></i></div>
                    <h2>Application Submitted!</h2>
                    <p>
                        {{ session('success') }}
                        You're now logged into your student account. Our admissions team will review your
                        application and update you within 2–3 business days.
                    </p>

                    <div class="lipa-success-actions">
                        <a href="{{ route('student.dashboard') }}" id="dashboardBtn" class="lipa-btn-primary">
                            <span id="dashboardBtnText">
                                <i class="fas fa-arrow-right-to-bracket"></i> View Learning Space
                            </span>
                        </a>
                    </div>
                </div>
            @else
                {{-- ================= REGISTRATION WIZARD ================= --}}
                <div class="card lipa-card shadow-lg">

                    {{-- Progress Bar --}}
                    <div class="progress lipa-progress mb-2">
                        <div id="progressBar" class="progress-bar lipa-progress-bar" style="width: 20%;"></div>
                    </div>
                    <p id="stepCounter" class="text-center text-muted small mb-4">Step 1 of 5</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <p class="font-weight-bold mb-1">Please correct the following:</p>
                            <ul class="mb-0 pl-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('public.students.store') }}" method="POST" enctype="multipart/form-data"
                        id="registrationForm" novalidate>
                        @csrf

                        {{-- ============ STEP 1: Personal & Employment ============ --}}
                        <div class="form-step active" data-step="1">
                            <h4 class="lipa-step-heading">
                                <i class="fas fa-id-card"></i> Personal Information
                            </h4>
                            <p class="lipa-step-sub">Tell us about yourself</p>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        class="form-control form-control-lg required">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select name="gender" required class="form-control form-control-lg required">
                                        <option value="">Select...</option>
                                        <option value="male" @selected(old('gender') == 'male')>Male</option>
                                        <option value="female" @selected(old('gender') == 'female')>Female</option>
                                        <option value="other" @selected(old('gender') == 'other')>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                        required class="form-control form-control-lg required">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Nationality <span class="text-danger">*</span></label>
                                    <input type="text" name="nationality" value="{{ old('nationality') }}" required
                                        class="form-control form-control-lg required">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">County of Residence <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="county_of_residence"
                                        value="{{ old('county_of_residence') }}" required
                                        class="form-control form-control-lg required">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile_number" value="{{ old('mobile_number') }}"
                                        placeholder="e.g. 0770123456" required
                                        class="form-control form-control-lg required">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Home Address <span class="text-danger">*</span></label>
                                    <textarea name="home_address" rows="2" required class="form-control form-control-lg required">{{ old('home_address') }}</textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">WhatsApp Number <span
                                            class="text-muted small">(optional)</span></label>
                                    <input type="text" name="whatsapp_number"
                                        value="{{ old('whatsapp_number') }}" class="form-control form-control-lg">
                                </div>
                            </div>

                            <hr class="my-4">

                            <h4 class="lipa-step-heading">
                                <i class="fas fa-briefcase"></i> Employment
                            </h4>
                            <p class="lipa-step-sub">Your current employment situation</p>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Employment Status <span
                                            class="text-danger">*</span></label>
                                    <select name="employment_status" required
                                        class="form-control form-control-lg required">
                                        <option value="">Select...</option>
                                        <option value="employed" @selected(old('employment_status') == 'employed')>Employed</option>
                                        <option value="self_employed" @selected(old('employment_status') == 'self_employed')>Self-Employed
                                        </option>
                                        <option value="unemployed" @selected(old('employment_status') == 'unemployed')>Unemployed</option>
                                        <option value="student" @selected(old('employment_status') == 'student')>Student</option>
                                        <option value="other" @selected(old('employment_status') == 'other')>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Employer Name</label>
                                    <input type="text" name="employer_name" value="{{ old('employer_name') }}"
                                        class="form-control form-control-lg">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Position / Title</label>
                                    <input type="text" name="position_title" value="{{ old('position_title') }}"
                                        class="form-control form-control-lg">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Employer Contact Person</label>
                                    <input type="text" name="institution_contact_detail"
                                        value="{{ old('institution_contact_detail') }}"
                                        class="form-control form-control-lg">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Years of Experience</label>
                                    <input type="number" min="0" name="years_experience"
                                        value="{{ old('years_experience') }}" class="form-control form-control-lg">
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Employer Contact Info <span
                                            class="text-muted small">(phone/email/address)</span></label>
                                    <textarea name="institution_contact_info" rows="2" class="form-control form-control-lg">{{ old('institution_contact_info') }}</textarea>
                                </div>
                            </div>

                            <button type="button" class="btn lipa-btn-primary next-btn mt-2">
                                Next <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>

                        {{-- ============ STEP 2: Education & Documents ============ --}}
                        <div class="form-step" data-step="2">
                            <h4 class="lipa-step-heading">
                                <i class="fas fa-graduation-cap"></i> Education
                            </h4>
                            <p class="lipa-step-sub">Your academic background</p>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Highest Qualification <span
                                            class="text-danger">*</span></label>
                                    <select name="highest_qualification" required
                                        class="form-control form-control-lg required">
                                        <option value="">Select...</option>
                                        <option value="certificate" @selected(old('highest_qualification') == 'certificate')>Certificate</option>
                                        <option value="diploma" @selected(old('highest_qualification') == 'diploma')>Diploma</option>
                                        <option value="bachelor" @selected(old('highest_qualification') == 'bachelor')>Bachelor's Degree
                                        </option>
                                        <option value="master" @selected(old('highest_qualification') == 'master')>Master's Degree</option>
                                        <option value="doctorate" @selected(old('highest_qualification') == 'doctorate')>Doctorate</option>
                                        <option value="other" @selected(old('highest_qualification') == 'other')>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Year Completed</label>
                                    <input type="number" name="year_completed" value="{{ old('year_completed') }}"
                                        class="form-control form-control-lg">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Institution Attended</label>
                                    <input type="text" name="institution_attended"
                                        value="{{ old('institution_attended') }}"
                                        class="form-control form-control-lg">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Field of Study</label>
                                    <input type="text" name="field_of_study" value="{{ old('field_of_study') }}"
                                        class="form-control form-control-lg">
                                </div>
                            </div>

                            <hr class="my-4">

                            <h4 class="lipa-step-heading">
                                <i class="fas fa-file-upload"></i> Documents
                            </h4>
                            <p class="lipa-step-sub">Photo and academic records</p>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="lipa-file-box">
                                        <label class="form-label">Passport Photo</label>
                                        <input type="file" name="passport_photo" id="passportPhotoInput"
                                            accept="image/*" class="form-control-file">
                                        <img id="passportPhotoPreview" class="lipa-photo-preview d-none">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="lipa-file-box">
                                        <label class="form-label">Academic Certificate <span
                                                class="text-muted small">(PDF or
                                                image)</span></label>
                                        <input type="file" name="academic_certificate" id="certificateInput"
                                            accept=".pdf,.jpg,.jpeg,.png" class="form-control-file">
                                        <p id="certificateName" class="lipa-file-name d-none">
                                            <i class="fas fa-file-lines"></i> <span></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary prev-btn mt-2">
                                <i class="fas fa-arrow-left mr-1"></i> Previous
                            </button>
                            <button type="button" class="btn lipa-btn-primary next-btn mt-2">
                                Next <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>

                        {{-- ============ STEP 3: Course, Sponsorship & Emergency Contact ============ --}}
                        <div class="form-step" data-step="3">
                            <h4 class="lipa-step-heading">
                                <i class="fas fa-book-open"></i> Course &amp; Sponsorship
                            </h4>
                            <p class="lipa-step-sub">Which course, intake, and how it's funded</p>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Course <span class="text-danger">*</span></label>
                                    <select name="course_id" required class="form-control form-control-lg required">
                                        <option value="">Select a course...</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}" @selected(old('course_id') == $course->id)>
                                                {{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cohort <span class="text-danger">*</span></label>
                                    <select name="cohort_id" required class="form-control form-control-lg required">
                                        <option value="">Select a cohort...</option>
                                        @foreach ($cohorts as $cohort)
                                            <option value="{{ $cohort->id }}" @selected(old('cohort_id') == $cohort->id)>
                                                {{ $cohort->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">How did you hear about LIPA?</label>
                                    <input type="text" name="how_heard_about_us"
                                        value="{{ old('how_heard_about_us') }}" class="form-control form-control-lg">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Sponsorship Type <span
                                            class="text-danger">*</span></label>
                                    <select name="sponsorship_type" id="sponsorshipType" required
                                        class="form-control form-control-lg required">
                                        <option value="">Select...</option>
                                        <option value="self" @selected(old('sponsorship_type') == 'self')>Self-Sponsored</option>
                                        <option value="employer" @selected(old('sponsorship_type') == 'employer')>Employer-Sponsored
                                        </option>
                                        <option value="other" @selected(old('sponsorship_type') == 'other')>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 d-none" id="sponsorOrgWrapper">
                                    <label class="form-label">Sponsor Organization Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="sponsor_organization_name"
                                        value="{{ old('sponsor_organization_name') }}"
                                        class="form-control form-control-lg">
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="lipa-check">
                                        <input type="checkbox" name="requires_invoice" id="requires_invoice"
                                            value="1">
                                        <label for="requires_invoice">Requires an invoice</label>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h4 class="lipa-step-heading">
                                <i class="fas fa-phone-volume"></i> Emergency Contact
                            </h4>
                            <p class="lipa-step-sub">Who should we reach in an emergency</p>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Emergency Contact Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="emergency_contact_name"
                                        value="{{ old('emergency_contact_name') }}" required
                                        class="form-control form-control-lg required">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Emergency Contact Phone <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="emergency_contact_phone"
                                        value="{{ old('emergency_contact_phone') }}" required
                                        class="form-control form-control-lg required">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Relationship <span class="text-danger">*</span></label>
                                    <input type="text" name="emergency_contact_relationship"
                                        value="{{ old('emergency_contact_relationship') }}" required
                                        class="form-control form-control-lg required">
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="lipa-check">
                                        <input type="checkbox" name="requires_special_accommodation"
                                            id="requires_accommodation" value="1">
                                        <label for="requires_accommodation">Requires special accommodation</label>
                                    </div>
                                </div>
                                <div class="col-12 mb-3 d-none" id="accommodationWrapper">
                                    <label class="form-label">Accommodation Details</label>
                                    <textarea name="special_accommodation_details" rows="2" class="form-control form-control-lg">{{ old('special_accommodation_details') }}</textarea>
                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary prev-btn mt-2">
                                <i class="fas fa-arrow-left mr-1"></i> Previous
                            </button>
                            <button type="button" class="btn lipa-btn-primary next-btn mt-2">
                                Next <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>

                        {{-- ============ STEP 4: Account Setup & Training Needs ============ --}}
                        <div class="form-step" data-step="4">
                            <h4 class="lipa-step-heading">
                                <i class="fas fa-key"></i> Account Setup
                            </h4>
                            <p class="lipa-step-sub">Create your login</p>

                            <div class="lipa-info-box mb-3">
                                <i class="fas fa-circle-info"></i>
                                <span>A Student ID (e.g. LIPA/STU/{{ now()->year }}/0001) is generated automatically,
                                    and
                                    you'll be logged in right away. Your account is reviewed shortly after for final
                                    activation.</span>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="form-control form-control-lg required">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="passwordInput" required
                                        minlength="8" class="form-control form-control-lg required">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirm Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="passwordConfirmInput"
                                        required minlength="8" class="form-control form-control-lg required">
                                    <p id="passwordMatchMsg" class="d-none small mt-1 mb-0 font-weight-bold"></p>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h4 class="lipa-step-heading">
                                <i class="fas fa-clipboard-list"></i> Training Needs Assessment
                            </h4>
                            <p class="lipa-step-sub">Help us understand your goals</p>

                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Why are you interested in this course?</label>
                                    <textarea name="interest_reason" rows="3" class="form-control form-control-lg">{{ old('interest_reason') }}</textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Skills you hope to gain</label>
                                    <textarea name="skills_hoped_to_gain" rows="3" class="form-control form-control-lg">{{ old('skills_hoped_to_gain') }}</textarea>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="lipa-check">
                                        <input type="checkbox" name="previously_attended_lipa_training"
                                            id="previously_attended" value="1">
                                        <label for="previously_attended">I've previously attended LIPA training</label>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary prev-btn mt-2">
                                <i class="fas fa-arrow-left mr-1"></i> Previous
                            </button>
                            <button type="button" class="btn lipa-btn-primary next-btn mt-2">
                                Next <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>

                        {{-- ============ STEP 5: Review & Submit ============ --}}
                        <div class="form-step" data-step="5">
                            <h4 class="lipa-step-heading">
                                <i class="fas fa-check-circle"></i> Review &amp; Submit
                            </h4>
                            <p class="lipa-step-sub">Confirm your details before submitting</p>

                            <div id="reviewSummary" class="lipa-review-box"></div>

                            <button type="button" class="btn btn-secondary prev-btn mt-3">
                                <i class="fas fa-arrow-left mr-1"></i> Previous
                            </button>
                            <button type="submit" id="submitBtn" class="btn lipa-btn-submit mt-3">
                                <span id="submitBtnText">
                                    <i class="fas fa-check mr-1"></i> Submit Registration
                                </span>
                            </button>
                        </div>

                    </form>
                </div>

            @endif

        </section>

    </div>

    {{-- Bootstrap JS bundle (Popper included) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- ================= JAVASCRIPT ================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('registrationForm');

            /* ---- Dashboard button loading state (works whether or not the wizard exists) ---- */
            const dashboardBtn = document.getElementById('dashboardBtn');
            dashboardBtn?.addEventListener('click', function(e) {
                e.preventDefault();
                const btn = this;
                const target = btn.getAttribute('href');

                btn.classList.add('is-loading');
                btn.querySelector('#dashboardBtnText').innerHTML =
                    '<span class="lipa-spinner"></span> Loading your dashboard...';

                setTimeout(function() {
                    window.location.href = target;
                }, 350);
            });

            if (!form) return; // success card is showing, no wizard to wire up

            const steps = Array.from(document.querySelectorAll('.form-step'));
            const totalSteps = steps.length;
            let currentStep = 1;

            const progressBar = document.getElementById('progressBar');
            const stepCounter = document.getElementById('stepCounter');

            function currentStepEl() {
                return steps.find(el => parseInt(el.dataset.step) === currentStep);
            }

            function showStep(step) {
                steps.forEach(el => {
                    el.classList.toggle('active', parseInt(el.dataset.step) === step);
                });

                progressBar.style.width = Math.round((step / totalSteps) * 100) + '%';
                stepCounter.textContent = `Step ${step} of ${totalSteps}`;

                if (step === totalSteps) {
                    buildReviewSummary();
                }

                window.scrollTo({
                    top: form.offsetTop - 100,
                    behavior: 'smooth'
                });
            }

            function validateCurrentStep() {
                const inputs = currentStepEl().querySelectorAll('.required');
                let valid = true;

                inputs.forEach(input => {
                    if (!input.checkValidity()) {
                        input.classList.add('is-invalid');
                        input.reportValidity();
                        valid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                return valid;
            }

            document.querySelectorAll('.next-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (!validateCurrentStep()) return;
                    if (currentStep < totalSteps) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });
            });

            document.querySelectorAll('.prev-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (currentStep > 1) {
                        currentStep--;
                        showStep(currentStep);
                    }
                });
            });

            form.addEventListener('submit', function(e) {
                for (const step of steps) {
                    const stepNum = parseInt(step.dataset.step);
                    const inputs = step.querySelectorAll('.required');
                    for (const input of inputs) {
                        if (!input.checkValidity()) {
                            e.preventDefault();
                            currentStep = stepNum;
                            showStep(currentStep);
                            input.classList.add('is-invalid');
                            input.reportValidity();
                            return;
                        }
                    }
                }

                // All steps valid — show loading state on the submit button.
                // Form still submits normally (no e.preventDefault here).
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.classList.add('is-loading');
                document.getElementById('submitBtnText').innerHTML =
                    '<span class="lipa-spinner"></span> Submitting your application...';
            });

            const sponsorshipType = document.getElementById('sponsorshipType');
            const sponsorOrgWrapper = document.getElementById('sponsorOrgWrapper');
            sponsorshipType?.addEventListener('change', function() {
                sponsorOrgWrapper.classList.toggle('d-none', !['employer', 'other'].includes(this.value));
            });

            const accommodationCheckbox = document.getElementById('requires_accommodation');
            const accommodationWrapper = document.getElementById('accommodationWrapper');
            accommodationCheckbox?.addEventListener('change', function() {
                accommodationWrapper.classList.toggle('d-none', !this.checked);
            });

            const passportInput = document.getElementById('passportPhotoInput');
            const passportPreview = document.getElementById('passportPhotoPreview');
            passportInput?.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    passportPreview.src = URL.createObjectURL(this.files[0]);
                    passportPreview.classList.remove('d-none');
                }
            });

            const certificateInput = document.getElementById('certificateInput');
            const certificateName = document.getElementById('certificateName');
            certificateInput?.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    certificateName.querySelector('span').textContent = this.files[0].name;
                    certificateName.classList.remove('d-none');
                }
            });

            const passwordInput = document.getElementById('passwordInput');
            const passwordConfirmInput = document.getElementById('passwordConfirmInput');
            const passwordMatchMsg = document.getElementById('passwordMatchMsg');

            function checkPasswordMatch() {
                if (!passwordConfirmInput.value) {
                    passwordMatchMsg.classList.add('d-none');
                    passwordConfirmInput.setCustomValidity('');
                    return;
                }

                const matches = passwordInput.value === passwordConfirmInput.value;

                passwordMatchMsg.classList.remove('d-none');
                passwordMatchMsg.style.color = matches ? '#16a34a' : '#dc3545';
                passwordMatchMsg.innerHTML = matches ?
                    '<i class="fas fa-check-circle mr-1"></i> Passwords match' :
                    '<i class="fas fa-times-circle mr-1"></i> Passwords do not match';

                passwordConfirmInput.setCustomValidity(matches ? '' : 'Passwords do not match');
            }

            passwordInput?.addEventListener('input', checkPasswordMatch);
            passwordConfirmInput?.addEventListener('input', checkPasswordMatch);

            function buildReviewSummary() {
                const get = (name) => form.querySelector(`[name="${name}"]`)?.value || '—';
                const getSelectText = (name) => {
                    const el = form.querySelector(`[name="${name}"]`);
                    return el && el.selectedIndex >= 0 ? el.options[el.selectedIndex].text : '—';
                };

                const rows = [
                    ['Full Name', get('name')],
                    ['Email', get('email')],
                    ['Mobile Number', get('mobile_number')],
                    ['Course', getSelectText('course_id')],
                    ['Cohort', getSelectText('cohort_id')],
                    ['Sponsorship', getSelectText('sponsorship_type')],
                    ['Emergency Contact', get('emergency_contact_name')],
                ];

                document.getElementById('reviewSummary').innerHTML = rows.map(([label, value]) =>
                    `<div class="lipa-review-row">
                        <span class="lipa-review-label">${label}</span>
                        <span class="lipa-review-value">${value}</span>
                    </div>`
                ).join('');
            }

            showStep(currentStep);
        });
    </script>

</body>

</html>
