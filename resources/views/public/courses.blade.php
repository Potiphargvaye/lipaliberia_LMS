@extends('public.layouts.public')

@section('title', 'Our Courses | Liberia Institute of Public Administration')

@section('description',
    'Explore certificate courses, flagship training programmes, and public sector orientation
    programmes offered by the Liberia Institute of Public Administration (LIPA).')

@section('content')

    <!-- Everything that was INSIDE <main> from about.html goes here -->

    <main>

        {{-- Slider Area --}}
        <section class="slider-area slider-area2">
            <div class="slider-active">
                <div class="single-slider slider-height2">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-8 col-lg-11 col-md-12">
                                <div class="hero__caption hero__caption2">
                                    <h1 data-animation="bounceIn" data-delay="0.2s">Our courses</h1>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                            <li class="breadcrumb-item"><a href="#">Courses</a></li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============================================================
             COURSE GROUPS — data-driven from config/courses.php
             Every card's title and buttons link to the dynamic Course
             Details page for that specific course (route: courses.show).
        ============================================================ --}}
        @foreach ($groups as $groupKey => $groupCourses)
            @continue($groupCourses->isEmpty())

            <div class="courses-area section-padding40 fix">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-7 col-lg-8">
                            <div class="section-tittle text-center mb-55">
                                <h2>{{ $groupCourses->first()['group_label'] }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($groupCourses as $course)
                            <div class="col-lg-4">
                                <div class="properties properties2 mb-30">
                                    <div class="properties__card">
                                        <div class="properties__img overlay1">
                                            <a href="{{ route('courses.show', $course['slug']) }}">
                                                <img src="{{ asset('lipa-liberia-public-site/assets/img/courses_images/' . $course['image']) }}"
                                                    alt="{{ $course['title'] }}">
                                            </a>
                                        </div>
                                        <div class="properties__caption">
                                            <p>{{ $course['category'] }}</p>
                                            <h3>
                                                <a
                                                    href="{{ route('courses.show', $course['slug']) }}">{{ $course['title'] }}</a>
                                            </h3>
                                            <p>{{ $course['overview'] }}</p>

                                            <div
                                                class="properties__footer d-flex justify-content-between align-items-center">
                                                <div class="restaurant-name">
                                                    <div class="rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star-half"></i>
                                                    </div>
                                                    <p><span>(4.5)</span> {{ $course['programme_type'] }}</p>
                                                </div>
                                                <div class="price">
                                                    <span>{{ $course['fee'] }} &rarr; {{ $course['duration'] }}</span>
                                                </div>
                                            </div>

                                            <a href="{{ route('courses.show', $course['slug']) }}"
                                                class="border-btn border-btn2">
                                                Learn More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Services strip --}}
        <div class="services-area services-area2 section-padding40">
            <div class="container">
                <div class="row justify-content-sm-center">
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="single-services mb-30">
                            <div class="features-icon">
                                <img src="{{ asset('assets/img/icon/icon1.svg') }}" alt="">
                            </div>
                            <div class="features-caption">
                                <h3>{{ collect(config('courses'))->count() }}+ Courses</h3>
                                <p>Certificate, flagship, and orientation programmes for public sector professionals.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="single-services mb-30">
                            <div class="features-icon">
                                <img src="{{ asset('assets/img/icon/icon2.svg') }}" alt="">
                            </div>
                            <div class="features-caption">
                                <h3>Expert instructors</h3>
                                <p>Learn from experienced public administration practitioners and facilitators.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="single-services mb-30">
                            <div class="features-icon">
                                <img src="{{ asset('assets/img/icon/icon3.svg') }}" alt="">
                            </div>
                            <div class="features-caption">
                                <h3>Lifetime access</h3>
                                <p>Materials and resources remain available to support your continued learning.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
