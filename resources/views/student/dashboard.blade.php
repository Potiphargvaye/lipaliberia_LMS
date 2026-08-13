@extends('layouts.student')

@section('content')

    <div class="container-fluid px-3 px-lg-4 py-4">

        {{-- Welcome Header --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body d-flex flex-column flex-sm-row align-items-center align-items-sm-center gap-3 p-3 p-md-4">
                <img src="{{ $student->passport_photo_path ? Storage::url($student->passport_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=155E8A&color=fff' }}"
                    alt="{{ $student->name }}" class="rounded-circle border"
                    style="width: 72px; height: 72px; object-fit: cover;">

                <div class="text-center text-sm-start flex-grow-1">
                    <h4 class="mb-1 fw-bold">Welcome back, {{ explode(' ', $student->name)[0] }} 👋</h4>
                    <div
                        class="d-flex flex-wrap justify-content-center justify-content-sm-start gap-2 gap-sm-3 small text-muted">
                        <span><i class="bi bi-person-vcard me-1"></i>{{ $student->name }}</span>
                        <span><i class="bi bi-upc-scan me-1"></i>{{ $student->user?->registration_id ?? '—' }}</span>
                        <span><i class="bi bi-envelope me-1"></i>{{ $student->user?->email ?? '—' }}</span>
                    </div>
                </div>

                @if (Route::has('student.profile'))
                    <a href="{{ route('student.profile') }}"
                        class="btn btn-outline-primary btn-sm align-self-center align-self-sm-auto">
                        <i class="bi bi-person-badge me-1"></i> View Profile
                    </a>
                @endif
            </div>
        </div>

        {{-- Quick Statistics --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width:44px;height:44px;">
                            <i class="bi bi-file-earmark-text fs-5"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold lh-1">{{ $stats['applications'] }}</div>
                            <div class="small text-muted">Applications</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width:44px;height:44px;">
                            <i class="bi bi-mortarboard fs-5"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold lh-1">{{ $stats['active_enrollments'] }}</div>
                            <div class="small text-muted">Active Enrollments</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width:44px;height:44px;">
                            <i class="bi bi-check-circle fs-5"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold lh-1">{{ $stats['completed_courses'] }}</div>
                            <div class="small text-muted">Completed</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width:44px;height:44px;">
                            <i class="bi bi-award fs-5"></i>
                        </div>
                        <div>
                            <div class="fs-4 fw-bold lh-1">{{ $stats['certificates'] }}</div>
                            <div class="small text-muted">Certificates</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">

            {{-- Latest Application Status --}}
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header border-0 pt-3 pb-0">
                        <h6 class="fw-bold mb-0"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Latest Application
                        </h6>
                    </div>
                    <div class="card-body">
                        @if ($latestApplication)
                            <p class="mb-2 fw-semibold">{{ $latestApplication->course->title ?? 'Course' }}</p>
                            <p class="mb-3 small text-muted">
                                Cohort: {{ $latestApplication->cohort->name ?? '—' }} &middot;
                                Submitted {{ $latestApplication->created_at->format('M d, Y') }}
                            </p>

                            @if ($latestApplication->status === 'pending')
                                <div class="alert alert-warning d-flex align-items-center gap-2 mb-0" role="alert">
                                    <i class="bi bi-hourglass-split fs-5"></i>
                                    <div>
                                        <strong>Pending Review</strong>
                                        <div class="small">Our admissions team is reviewing your application.</div>
                                    </div>
                                </div>
                            @elseif ($latestApplication->status === 'approved')
                                <div class="alert alert-success d-flex align-items-center gap-2 mb-0" role="alert">
                                    <i class="bi bi-check-circle fs-5"></i>
                                    <div>
                                        <strong>Congratulations — Approved!</strong>
                                        <div class="small">
                                            @if ($activeEnrollment)
                                                You're enrolled and your status is
                                                <strong>{{ ucfirst(str_replace('_', ' ', $activeEnrollment->status)) }}</strong>.
                                            @else
                                                Your enrollment is being set up.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @elseif ($latestApplication->status === 'rejected')
                                <div class="alert alert-danger mb-0" role="alert">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="bi bi-x-circle fs-5"></i>
                                        <strong>Not Approved</strong>
                                    </div>
                                    <div class="small">
                                        {{ $latestApplication->rejection_reason ?: 'No reason was provided.' }}
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-secondary mb-0" role="alert">
                                    <strong>{{ ucfirst($latestApplication->status) }}</strong>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-file-earmark-plus fs-1 text-muted d-block mb-2"></i>
                                <p class="text-muted mb-0">You haven't submitted an application yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Current Enrollment --}}
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header border-0 pt-3 pb-0">
                        <h6 class="fw-bold mb-0"><i class="bi bi-mortarboard me-2 text-primary"></i>Current Enrollment</h6>
                    </div>
                    <div class="card-body">
                        @php $enrollmentToShow = $activeEnrollment ?? $completedEnrollment; @endphp

                        @if ($enrollmentToShow)
                            <p class="mb-1 fw-semibold">{{ $enrollmentToShow->course->title ?? 'Course' }}</p>
                            <p class="mb-3 small text-muted">Cohort: {{ $enrollmentToShow->cohort->name ?? '—' }}</p>

                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span
                                    class="badge rounded-pill
                                    @if ($enrollmentToShow->status === 'completed') bg-success
                                    @elseif ($enrollmentToShow->status === 'in_training') bg-primary
                                    @elseif ($enrollmentToShow->status === 'enrolled') bg-info text-dark
                                    @elseif ($enrollmentToShow->status === 'suspended') bg-warning text-dark
                                    @else bg-secondary @endif">
                                    {{ ucfirst(str_replace('_', ' ', $enrollmentToShow->status)) }}
                                </span>

                                @if ($enrollmentToShow->status === 'in_training')
                                    <span class="small text-muted">{{ $enrollmentToShow->progress_percentage ?? 0 }}%
                                        complete</span>
                                @endif
                            </div>

                            @if ($enrollmentToShow->status === 'in_training')
                                <div class="progress mb-3" style="height: 8px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $enrollmentToShow->progress_percentage ?? 0 }}%"
                                        aria-valuenow="{{ $enrollmentToShow->progress_percentage ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            @endif

                            @if ($enrollmentToShow->status === 'completed')
                                @if ($enrollmentToShow->certificate_issued && $enrollmentToShow->certificate_path)
                                    <a href="{{ Storage::url($enrollmentToShow->certificate_path) }}" target="_blank"
                                        class="btn btn-success btn-sm">
                                        <i class="bi bi-download me-1"></i> Download Certificate
                                    </a>
                                @else
                                    <div class="alert alert-info mb-0 py-2 px-3 small">
                                        <i class="bi bi-info-circle me-1"></i> Certificate not issued yet.
                                    </div>
                                @endif
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-mortarboard fs-1 text-muted d-block mb-2"></i>
                                <p class="text-muted mb-0">No active enrollment yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">

            {{-- Recent Activity --}}
            <div class="col-12 col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header border-0 pt-3 pb-0">
                        <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Activity</h6>
                    </div>
                    <div class="card-body">
                        @if ($activity->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach ($activity as $item)
                                    <li class="d-flex gap-3 {{ !$loop->last ? 'pb-3 mb-3 border-bottom' : '' }}">
                                        <div class="rounded-circle bg-{{ $item['variant'] }} bg-opacity-10 text-{{ $item['variant'] }} d-flex align-items-center justify-content-center flex-shrink-0"
                                            style="width:36px;height:36px;">
                                            <i class="bi {{ $item['icon'] }}"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold small">{{ $item['title'] }}</div>
                                            <div class="text-muted small">{{ $item['description'] }}</div>
                                            <div class="text-muted small">{{ $item['date']->diffForHumans() }}</div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-clock-history fs-1 text-muted d-block mb-2"></i>
                                <p class="text-muted mb-0">No recent activity yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Fees Status Brief --}}
            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header border-0 pt-3 pb-0 d-flex align-items-center justify-content-between">
                        <h6 class="fw-bold mb-0"><i class="bi bi-cash-coin me-2 text-primary"></i>Fees Status</h6>
                        @if (Route::has('student.fees.index'))
                            <a href="{{ route('student.fees.index') }}" class="small text-decoration-none">View
                                details</a>
                        @endif
                    </div>
                    <div class="card-body">

                        @if ($feesOverallStatus === 'no_fees')
                            <div class="text-center py-4">
                                <i class="bi bi-cash-coin fs-1 text-muted d-block mb-2"></i>
                                <p class="text-muted mb-0">No fees assigned yet.</p>
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span
                                    class="badge rounded-pill
                                    @if ($feesOverallStatus === 'paid') bg-success
                                    @elseif ($feesOverallStatus === 'partial') bg-warning text-dark
                                    @else bg-danger @endif">
                                    {{ ucfirst($feesOverallStatus) }}
                                </span>
                                <span class="small text-muted">{{ $feesPercentPaid }}% paid</span>
                            </div>

                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar {{ $feesOverallStatus === 'paid' ? 'bg-success' : 'bg-primary' }}"
                                    role="progressbar" style="width: {{ $feesPercentPaid }}%"
                                    aria-valuenow="{{ $feesPercentPaid }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Total fees</span>
                                <span class="fw-semibold">${{ number_format($feesTotalAssigned, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Amount paid</span>
                                <span class="fw-semibold text-success">${{ number_format($feesTotalPaid, 2) }}</span>
                            </div>

                            @if ($feesBalance > 0)
                                <div class="d-flex justify-content-between small mt-2 pt-2 border-top">
                                    <span class="text-danger fw-semibold">
                                        Outstanding ({{ $feesOutstandingCount }}
                                        {{ Str::plural('fee', $feesOutstandingCount) }})
                                    </span>
                                    <span class="text-danger fw-bold">${{ number_format($feesBalance, 2) }}</span>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>

        {{-- Announcements --}}
        <div class="row g-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header border-0 pt-3 pb-0">
                        <h6 class="fw-bold mb-0"><i class="bi bi-megaphone me-2 text-primary"></i>Announcements</h6>
                    </div>
                    <div class="card-body">
                        {{--
                            No announcements table/model exists yet. Once one is
                            added, replace this block with a loop over the
                            announcements passed from the controller — the
                            empty state below is the placeholder until then.
                        --}}
                        <div class="text-center py-4">
                            <i class="bi bi-megaphone fs-1 text-muted d-block mb-2"></i>
                            <p class="text-muted mb-0">No announcements right now — check back soon.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
