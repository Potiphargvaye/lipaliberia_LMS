@extends('layouts.student')


@section('title', 'Live Classes | LIPA LMS')

@section('content')

    <div class="container-fluid px-3 px-md-4 py-4 lc-page">

        {{-- Page Header --}}
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">

            <div>
                <h1 class="h4 fw-bold mb-1">
                    Live Classes
                </h1>

                <p class="text-muted mb-0">
                    View and join your scheduled live learning sessions.
                </p>
            </div>

            <div class="mt-3 mt-md-0">
                <span class="badge rounded-pill bg-light text-secondary border px-3 py-2">
                    <i class="bi bi-camera-video me-1"></i>
                    Live Learning
                </span>
            </div>

        </div>


        @if ($liveNow->isEmpty() && $upcoming->isEmpty() && $past->isEmpty())

            {{-- Empty State --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <div class="card-body py-5 px-3 px-md-5">

                    <div class="row justify-content-center">

                        <div class="col-lg-7 col-md-9 text-center">

                            <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 90px; height: 90px; background: rgba(14, 165, 233, 0.10); color: #0ea5e9;">
                                <i class="bi bi-camera-video fs-1"></i>
                            </div>

                            <h2 class="h4 fw-bold text-dark mb-3">
                                No Live Classes Scheduled
                            </h2>

                            <p class="text-muted mb-4 lh-lg">
                                You currently don't have any live classes scheduled.
                                Please check back later for upcoming sessions, meeting links,
                                and class announcements from your instructors.
                            </p>

                            <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="rounded-circle" style="width: 8px; height: 8px; background: #94a3b8;"></span>
                                <span class="small text-secondary">
                                    No sessions scheduled
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Helpful Information --}}
            <div class="row mt-4 g-3">

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center rounded-3"
                                    style="width: 42px; height: 42px; background: rgba(14, 165, 233, 0.10); color: #0ea5e9;">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Upcoming Classes</h6>
                                    <p class="small text-muted mb-0">Your upcoming sessions will appear here.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center rounded-3"
                                    style="width: 42px; height: 42px; background: rgba(16, 185, 129, 0.10); color: #10b981;">
                                    <i class="bi bi-link-45deg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Class Links</h6>
                                    <p class="small text-muted mb-0">Meeting links appear when a class is scheduled.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center rounded-3"
                                    style="width: 42px; height: 42px; background: rgba(245, 158, 11, 0.10); color: #f59e0b;">
                                    <i class="bi bi-bell"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Stay Updated</h6>
                                    <p class="small text-muted mb-0">Check your notifications for class announcements.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @else
            {{-- LIVE NOW --}}
            @if ($liveNow->isNotEmpty())
                <div class="mb-4">

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="lc-pulse-dot"></span>
                        <h2 class="h6 fw-bold text-dark mb-0">Live Now</h2>
                    </div>

                    <div class="row g-3">
                        @foreach ($liveNow as $liveClass)
                            <div class="col-12 col-lg-6">
                                @include('student.live-classes.partials.card', [
                                    'liveClass' => $liveClass,
                                    'variant' => 'live',
                                ])
                            </div>
                        @endforeach
                    </div>

                </div>
            @endif


            {{-- UPCOMING --}}
            @if ($upcoming->isNotEmpty())
                <div class="mb-4">

                    <h2 class="h6 fw-bold text-dark mb-3">Upcoming Sessions</h2>

                    <div class="row g-3">
                        @foreach ($upcoming as $liveClass)
                            <div class="col-12 col-lg-6">
                                @include('student.live-classes.partials.card', [
                                    'liveClass' => $liveClass,
                                    'variant' => 'upcoming',
                                ])
                            </div>
                        @endforeach
                    </div>

                </div>
            @endif


            {{-- PAST (collapsed by default to keep the page short on mobile) --}}
            @if ($past->isNotEmpty())
                <div class="mb-2">

                    <button
                        class="btn btn-link text-decoration-none fw-semibold text-secondary px-0 d-flex align-items-center gap-2 mb-2"
                        type="button" data-bs-toggle="collapse" data-bs-target="#lcPastSessions" aria-expanded="false"
                        aria-controls="lcPastSessions">
                        <i class="bi bi-clock-history"></i>
                        Past Sessions ({{ $past->count() }})
                        <i class="bi bi-chevron-down small"></i>
                    </button>

                    <div class="collapse" id="lcPastSessions">
                        <div class="row g-3">
                            @foreach ($past as $liveClass)
                                <div class="col-12 col-lg-6">
                                    @include('student.live-classes.partials.card', [
                                        'liveClass' => $liveClass,
                                        'variant' => 'past',
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            @endif

        @endif

    </div>


    <style>
        .lc-pulse-dot {
            width: 10px;
            height: 10px;
            border-radius: 9999px;
            background-color: #10b981;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6);
            animation: lc-pulse 1.8s infinite;
            flex-shrink: 0;
        }

        @keyframes lc-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.55);
            }

            70% {
                box-shadow: 0 0 0 9px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        .lc-card {
            transition: box-shadow 0.2s ease, transform 0.15s ease;
        }

        .lc-card:hover {
            box-shadow: 0 10px 25px -8px rgba(15, 76, 129, 0.18) !important;
        }

        /* Comfortable touch targets on small screens */
        @media (max-width: 767.98px) {
            .lc-join-btn {
                width: 100%;
                padding-top: 0.7rem;
                padding-bottom: 0.7rem;
                font-size: 0.95rem;
            }
        }
    </style>

@endsection
