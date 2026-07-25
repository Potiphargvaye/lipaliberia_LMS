@extends('public.layouts.public')

@section('title', $course['title'] . ' | Liberia Institute of Public Administration')

@section('description', $course['overview'])

@section('content')

    <main>

        {{-- ============================================================
             BREADCRUMB
        ============================================================ --}}
        <div class="breadcrumb-area">
            <div class="breadcrumb-banner d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-text">
                                <h2>{{ $course['title'] }}</h2>
                                <div class="breadcrumb-option">
                                    <a href="{{ url('/') }}">Home</a>
                                    <a href="{{ route('courses.index') }}">Courses</a>
                                    <span>{{ $course['title'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================
             BANNER IMAGE + META / ENROLL CARD
        ============================================================ --}}
        <section class="course-details-area section-padding40">
            <div class="container">
                <div class="row">

                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/' . $course['image']) }}"
                            alt="{{ $course['title'] }}" class="img-fluid rounded course-banner">
                    </div>

                    <div class="col-lg-4">
                        <div class="course-meta-card">
                            <div class="course-meta-row">
                                <span>Category</span>
                                <strong>{{ $course['category'] }}</strong>
                            </div>
                            <div class="course-meta-row">
                                <span>Training Fee</span>
                                <strong>{{ $course['fee'] }}</strong>
                            </div>
                            <div class="course-meta-row">
                                <span>Duration</span>
                                <strong>{{ $course['duration'] }}</strong>
                            </div>
                            <div class="course-meta-row">
                                <span>Available Seats</span>
                                <strong class="text-accent">{{ $course['seats'] }}</strong>
                            </div>
                            <div class="course-meta-row">
                                <span>Schedule</span>
                                <strong>{{ $course['schedule'] }}</strong>
                            </div>

                            @if (Route::has('registeration-form') || Route::has('registration.create'))
                                <a href="{{ Route::has('registeration-form') ? url('/registeration-form') : route('registration.create') }}"
                                    class="course-apply-btn">Apply Now</a>
                            @else
                                <a href="{{ url('/registeration-form') }}" class="course-apply-btn">Apply Now</a>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- ============================================================
                     COURSE DETAILS
                ============================================================ --}}
                <div class="row mt-5">

                    <div class="col-lg-8">

                        <div class="course-details-block">
                            <h3>Course Overview</h3>
                            <p>{{ $course['overview'] }}</p>
                        </div>

                        <div class="course-details-block">
                            <h3>Target Audience</h3>
                            <p>{{ $course['target_audience'] }}</p>
                        </div>

                        <div class="course-details-block">
                            <h3>Entry Requirements</h3>
                            <p>{{ $course['entry_requirements'] }}</p>
                        </div>

                        <div class="course-details-block">
                            <h3>Learning Outcomes</h3>
                            <ul class="course-outcomes-list">
                                @foreach ($course['learning_outcomes'] as $outcome)
                                    <li>{{ $outcome }}</li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        @if ($related->isNotEmpty())
                            <div class="related-courses-card">
                                <h4>Related Courses</h4>
                                @foreach ($related as $relatedCourse)
                                    <a href="{{ route('courses.show', $relatedCourse['slug']) }}"
                                        class="related-course-item">
                                        <img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/' . $relatedCourse['image']) }}"
                                            alt="{{ $relatedCourse['title'] }}">
                                        <div>
                                            <p class="related-course-title">{{ $relatedCourse['title'] }}</p>
                                            <span class="related-course-fee">{{ $relatedCourse['fee'] }} &rarr;
                                                {{ $relatedCourse['duration'] }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </section>

        <style>
            .course-banner {
                width: 100%;
                height: 380px;
                object-fit: cover;
            }

            .course-meta-card {
                border: 1px solid #E7ECF1;
                border-radius: 12px;
                padding: 24px;
                box-shadow: 0 10px 30px rgba(15, 76, 129, 0.06);
            }

            .course-meta-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px 0;
                border-bottom: 1px solid #EEF2F6;
                font-size: 14px;
                color: #64748B;
            }

            .course-meta-row:last-of-type {
                border-bottom: none;
            }

            .course-meta-row strong {
                color: #0F172A;
                font-weight: 700;
            }

            .course-meta-row strong.text-accent {
                color: #B91C1C;
            }

            .course-apply-btn {
                display: block;
                text-align: center;
                margin-top: 20px;
                padding: 14px;
                border-radius: 50px;
                font-weight: 600;
                color: #fff;
                background: linear-gradient(120deg, #0F4C81, #0EA5E9);
                transition: transform .2s ease, box-shadow .2s ease;
            }

            .course-apply-btn:hover {
                color: #fff;
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(15, 76, 129, 0.25);
            }

            .course-details-block {
                margin-bottom: 32px;
            }

            .course-details-block h3 {
                font-size: 20px;
                font-weight: 700;
                margin-bottom: 12px;
                color: #0F172A;
            }

            .course-details-block p {
                color: #475569;
                line-height: 1.7;
            }

            .course-outcomes-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .course-outcomes-list li {
                position: relative;
                padding-left: 28px;
                margin-bottom: 10px;
                color: #475569;
                line-height: 1.6;
            }

            .course-outcomes-list li::before {
                content: "";
                position: absolute;
                left: 0;
                top: 8px;
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: #0EA5E9;
            }

            .related-courses-card {
                border: 1px solid #E7ECF1;
                border-radius: 12px;
                padding: 20px;
            }

            .related-courses-card h4 {
                font-size: 16px;
                font-weight: 700;
                margin-bottom: 16px;
            }

            .related-course-item {
                display: flex;
                gap: 12px;
                align-items: center;
                padding: 10px 0;
                border-bottom: 1px solid #EEF2F6;
                color: inherit;
            }

            .related-course-item:last-child {
                border-bottom: none;
            }

            .related-course-item img {
                width: 56px;
                height: 56px;
                object-fit: cover;
                border-radius: 8px;
                flex-shrink: 0;
            }

            .related-course-title {
                font-size: 13px;
                font-weight: 600;
                margin: 0;
                color: #0F172A;
                line-height: 1.3;
            }

            .related-course-fee {
                font-size: 12px;
                color: #64748B;
            }

            @media (max-width: 767px) {
                .course-banner {
                    height: 220px;
                }
            }
        </style>

    </main>

@endsection
