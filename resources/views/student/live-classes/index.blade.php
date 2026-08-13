@extends('layouts.student')


@section('title', 'Live Classes | LIPA LMS')

@section('content')

    <div class="container-fluid px-3 px-md-4 py-4">

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


        {{-- Empty State --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

            <div class="card-body py-5 px-3 px-md-5">

                <div class="row justify-content-center">

                    <div class="col-lg-7 col-md-9 text-center">

                        {{-- Icon --}}
                        <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle"
                            style="
                            width: 90px;
                            height: 90px;
                            background: rgba(14, 165, 233, 0.10);
                            color: #0ea5e9;
                        ">
                            <i class="bi bi-camera-video fs-1"></i>
                        </div>


                        {{-- Title --}}
                        <h2 class="h4 fw-bold text-dark mb-3">
                            No Live Classes Scheduled
                        </h2>


                        {{-- Message --}}
                        <p class="text-muted mb-4 lh-lg">
                            You currently don't have any live classes scheduled for today.
                            Please check back later for upcoming sessions, meeting links,
                            and class announcements from your instructors.
                        </p>


                        {{-- Status --}}
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                            style="
                            background: #f8fafc;
                            border: 1px solid #e2e8f0;
                        ">
                            <span class="rounded-circle"
                                style="
                                width: 8px;
                                height: 8px;
                                background: #94a3b8;
                            "></span>

                            <span class="small text-secondary">
                                No session scheduled today
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
                                style="
                                width: 42px;
                                height: 42px;
                                background: rgba(14, 165, 233, 0.10);
                                color: #0ea5e9;
                            ">
                                <i class="bi bi-calendar-event"></i>
                            </div>

                            <div>
                                <h6 class="fw-semibold mb-1">
                                    Upcoming Classes
                                </h6>

                                <p class="small text-muted mb-0">
                                    Your upcoming sessions will appear here.
                                </p>
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
                                style="
                                width: 42px;
                                height: 42px;
                                background: rgba(16, 185, 129, 0.10);
                                color: #10b981;
                            ">
                                <i class="bi bi-link-45deg"></i>
                            </div>

                            <div>
                                <h6 class="fw-semibold mb-1">
                                    Class Links
                                </h6>

                                <p class="small text-muted mb-0">
                                    Meeting links will be available when a class is scheduled.
                                </p>
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
                                style="
                                width: 42px;
                                height: 42px;
                                background: rgba(245, 158, 11, 0.10);
                                color: #f59e0b;
                            ">
                                <i class="bi bi-bell"></i>
                            </div>

                            <div>
                                <h6 class="fw-semibold mb-1">
                                    Stay Updated
                                </h6>

                                <p class="small text-muted mb-0">
                                    Check your notifications for class announcements.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
