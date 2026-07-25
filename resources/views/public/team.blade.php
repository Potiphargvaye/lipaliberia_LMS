@extends('public.layouts.public')

@section('title', 'Our Team | Liberia Institute of Public Administration')

@section('description',
    'Meet the Board, Management and Senior Staff of the Liberia Institute of Public Administration (LIPA) —
    the people leading our work in public sector capacity, leadership development, and institutional excellence.')

@section('content')

    <!-- Everything that was INSIDE <main> from about.html goes here -->

    <main>

        {{-- ============================================================
             BREADCRUMB / PAGE HEADER
        ============================================================ --}}
        <div class="breadcrumb-area">
            <div class="breadcrumb-banner d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-text">
                                <h2>Our Team</h2>
                                <div class="breadcrumb-option">
                                    <a href="{{ url('/') }}">Home</a>
                                    <span>Our Team</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================
             INTRO
        ============================================================ --}}
        <section class="team-area section-padding40">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-9">
                        <div class="section-tittle text-center mb-60">
                            <h2 class="leadership-title">Meet Our Team</h2>
                            <p>
                                Get to know the Board, Management and Senior Staff who guide the Liberia Institute of
                                Public Administration in advancing public sector capacity, leadership, good governance,
                                and institutional excellence across Liberia.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ============================================================
                     BOARD CHAIR STATEMENT
                ============================================================ --}}
                <div class="row align-items-center mb-80">

                    <div class="col-lg-4 col-md-5 text-center mb-4 mb-lg-0">
                        <img src="{{ asset('lipa-liberia-public-site/assets/img/team/Emmanuel-board-chariman.jpg') }}"
                            alt="Board Chair" class="img-fluid shadow statement-photo-square">
                    </div>

                    <div class="col-lg-8 col-md-7">
                        <span class="text-uppercase text-primary font-weight-bold team-eyebrow">Board Chair</span>
                        <h3 class="mb-1 statement-name">Cllr. Emmanuel A. Tulay, Sr.</h3>
                        <p class="text-muted mb-4">Board Chair</p>

                        <h5 class="text-muted mb-4">Statement from the Board Chair</h5>

                        <p>
                            Welcome to the Liberia Institute of Public Administration. Our commitment is to strengthen
                            public sector institutions through quality education, leadership development, accountability
                            and professional excellence.
                        </p>
                        <p>
                            We remain dedicated to promoting integrity, innovation, transparency and sustainable national
                            development for Liberia.
                        </p>
                    </div>
                </div>

                {{-- ============================================================
                     BOARD MEMBERS
                ============================================================ --}}
                <div class="section-tittle mb-30">
                    <h3 class="team-group-title">Board Members</h3>
                </div>

                <div class="row">
                    @php
                        $boardMembers = [
                            [
                                'name' => 'Dr. Jarso Maley Jallah',
                                'role' => 'Institutional Member',
                                'image' => 'jarso-institution-member.png',
                            ],
                            [
                                'name' => 'Hon. Marie Haye',
                                'role' => 'Board Member',
                                'image' => 'lipa-logo.png',
                            ],
                            [
                                'name' => 'Hon. Georgetta Gray',
                                'role' => 'Board Member',
                                'image' => 'lipa-logo.png',
                            ],
                            [
                                'name' => 'Dr. Moses B. Jackson',
                                'role' => 'Board Member',
                                'image' => 'lipa-logo.png',
                            ],
                            [
                                'name' => 'Cllr. Martus William',
                                'role' => 'Board Member',
                                'image' => 'lipa-logo.png',
                            ],
                            [
                                'name' => 'Hon. Nee-Alah T. Varpilah',
                                'role' => 'Board Member',
                                'image' => 'DG.png',
                            ],
                        ];
                    @endphp

                    @foreach ($boardMembers as $member)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="single-cat text-center mb-30">
                                <div class="cat-icon">
                                    <img src="{{ asset('lipa-liberia-public-site/assets/img/team/' . $member['image']) }}"
                                        alt="{{ $member['name'] }}">
                                </div>
                                <div class="cat-cap">
                                    <h5 class="mb-0 team-name">{{ $member['name'] }}</h5>
                                    <span class="text-muted d-block team-role">{{ $member['role'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

        {{-- ============================================================
             MANAGEMENT TEAM
        ============================================================ --}}
        <section class="team-area section-padding40 bg-light-grey">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-9">
                        <div class="section-tittle text-center mb-60">
                            <h2 class="leadership-title">Management Team</h2>
                        </div>
                    </div>
                </div>

                {{-- Director General statement --}}
                <div class="row align-items-center mb-80">

                    <div class="col-lg-4 col-md-5 text-center mb-4 mb-lg-0">
                        <img src="{{ asset('lipa-liberia-public-site/assets/img/team/DG.png') }}" alt="Director General"
                            class="img-fluid shadow statement-photo-square">
                    </div>

                    <div class="col-lg-8 col-md-7">
                        <span class="text-uppercase text-primary font-weight-bold team-eyebrow">Director General</span>
                        <h3 class="mb-1 statement-name">Hon. Nee-Alah T. Varpilah</h3>
                        <p class="text-muted mb-4">Director General</p>

                        <h5 class="text-muted mb-4">Statement from the Director General</h5>

                        <p>
                            Welcome to the Liberia Institute of Public Administration. Our commitment is to strengthen
                            public sector institutions through quality education, leadership development, accountability
                            and professional excellence.
                        </p>
                        <p>
                            We remain dedicated to promoting integrity, innovation, transparency and sustainable national
                            development for Liberia.
                        </p>

                        <a href="" class="genric-btn primary radius">Read More</a>
                    </div>
                </div>

                {{-- Deputy Directors --}}
                <div class="section-tittle mb-30">
                    <h3 class="team-group-title">Deputy Directors</h3>
                </div>

                <div class="row mb-4">
                    @php
                        $deputyDirectors = [
                            [
                                'name' => 'Hon. Atty. Michael B. Wah Jr.',
                                'role' => 'Deputy Director',
                                'image' => 'wah-deputy-director.jpeg',
                            ],
                            [
                                'name' => 'Hon. Nukey M. Richards',
                                'role' => 'Deputy Director',
                                'image' => 'Nukey-deputy-director.png',
                            ],
                            [
                                'name' => 'Hon. Samuel M. Nyemah',
                                'role' => 'Deputy Director',
                                'image' => 'samuel.jpeg',
                            ],
                        ];
                    @endphp

                    @foreach ($deputyDirectors as $deputy)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="single-cat text-center mb-30">
                                <div class="cat-icon">
                                    <img src="{{ asset('lipa-liberia-public-site/assets/img/team/' . $deputy['image']) }}"
                                        alt="{{ $deputy['name'] }}">
                                </div>
                                <div class="cat-cap">
                                    <h5 class="mb-0 team-name">{{ $deputy['name'] }}</h5>
                                    <span class="text-muted d-block team-role">{{ $deputy['role'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Senior Staff --}}
                <div class="section-tittle mb-30 mt-4">
                    <h3 class="team-group-title">Senior Staff</h3>
                </div>

                <div class="row">
                    @php
                        $seniorStaff = [
                            [
                                'name' => 'Mr. Christian Weeks',
                                'role' => 'SA to the Director General',
                                'image' => 'christian.jpeg',
                            ],
                            [
                                'name' => 'Ms. Korpo K. Davis',
                                'role' => 'Human Resource Director',
                                'image' => 'korpo.jpeg',
                            ],
                            [
                                'name' => 'Mr. Korwan Zazay Flomo',
                                'role' => 'Comptroller',
                                'image' => 'korwan.png',
                            ],
                            [
                                'name' => 'Mr. George C. Nyanti',
                                'role' => 'Training Director',
                                'image' => 'George.png',
                            ],
                            [
                                'name' => 'Cllr. Thomas S.W. Neufville',
                                'role' => 'Legal Counsel',
                                'image' => 'Thomas1.jpeg',
                            ],
                            [
                                'name' => 'Mr. Samuel Gweh',
                                'role' => 'GSO Director',
                                'image' => 'Gweh.png',
                            ],
                            [
                                'name' => 'Mrs. Esigbemi K-Ogunkoyae',
                                'role' => 'Special Project Director',
                                'image' => 'Esigbemi.png',
                            ],
                            [
                                'name' => 'Mr. Joseph R. Massaley',
                                'role' => 'Head of ICT',
                                'image' => 'Joseph.png',
                            ],
                            [
                                'name' => 'Mr. G. Patrick Zeckeh',
                                'role' => 'Academic Registrar',
                                'image' => 'patrick.png',
                            ],
                        ];
                    @endphp

                    @foreach ($seniorStaff as $staff)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="single-cat text-center mb-30">
                                <div class="cat-icon">
                                    <img src="{{ asset('lipa-liberia-public-site/assets/img/team/' . $staff['image']) }}"
                                        alt="{{ $staff['name'] }}">
                                </div>
                                <div class="cat-cap">
                                    <h5 class="mb-0 team-name">{{ $staff['name'] }}</h5>
                                    <span class="text-muted d-block team-role">{{ $staff['role'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

        {{-- ============================================================
             OUR EXECUTIVE
        ============================================================ --}}
        <section class="team-area section-padding40">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-9">
                        <div class="section-tittle text-center mb-60">
                            <h2 class="leadership-title">Our Executive</h2>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    @php
                        $executives = [
                            ['name' => 'PRESIDENT', 'role' => 'President', 'image' => 'president.png'],
                            ['name' => 'VICE PRESIDENT', 'role' => 'Vice President', 'image' => 'vice president.png'],
                        ];
                    @endphp

                    @foreach ($executives as $executive)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="single-cat text-center mb-30">
                                <div class="cat-icon">
                                    <img src="{{ asset('lipa-liberia-public-site/assets/img/team/' . $executive['image']) }}"
                                        alt="{{ $executive['role'] }}">
                                </div>
                                <div class="cat-cap">
                                    <span class="text-primary d-block mb-2 team-eyebrow">{{ $executive['role'] }}</span>
                                    <h5 class="mb-0 team-name">{{ $executive['name'] }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>

        <style>
            /*
                                                                                 * NOTE: this theme applies its own font sizes to bare h2/h3/h5/span
                                                                                 * tags scoped by ancestor classes (e.g. ".single-cat .cat-cap span"),
                                                                                 * which is MORE specific than a single custom class like ".team-role"
                                                                                 * on its own. That extra specificity is what was overriding our sizing
                                                                                 * and rendering the role labels far larger than intended. The selectors
                                                                                 * below repeat the ".single-cat .cat-cap" (or equivalent) ancestor
                                                                                 * chain so our rules win the cascade, with !important as a hard backstop.
                                                                                 */

            .leadership-title,
            h2.leadership-title {
                font-size: 32px !important;
                font-weight: 700;
                line-height: 1.3;
            }

            .statement-name,
            h3.statement-name {
                font-size: 26px !important;
                font-weight: 700;
                line-height: 1.3;
            }

            .team-group-title,
            h3.team-group-title {
                font-size: 20px !important;
                font-weight: 700;
                padding-left: 12px;
                border-left: 4px solid #0F4C81;
            }

            /* square-format card photos, responsive at every breakpoint */
            .single-cat .cat-icon img {
                width: 100%;
                max-width: 170px;
                aspect-ratio: 1 / 1;
                object-fit: cover;
                border-radius: 14px;
                margin: auto;
            }

            /* square-format statement photos (Board Chair / Director General) */
            .statement-photo-square {
                width: 100%;
                max-width: 220px;
                aspect-ratio: 1 / 1;
                object-fit: cover;
                border-radius: 14px;
            }

            .single-cat .cat-cap span.team-eyebrow,
            .team-eyebrow {
                font-size: 13px !important;
                font-weight: 600;
                letter-spacing: 0.8px;
                text-transform: uppercase;
                line-height: 1.4;
            }

            .single-cat .cat-cap h5.team-name,
            .team-name {
                font-size: 18px !important;
                font-weight: 700;
                line-height: 1.4;
            }

            .single-cat .cat-cap span.team-role,
            .team-role {
                font-size: 13px !important;
                font-weight: 500;
                line-height: 1.4;
                margin-top: 2px;
            }

            .bg-light-grey {
                background-color: #F7F9FB;
            }

            @media (max-width: 767px) {
                .leadership-title {
                    font-size: 26px !important;
                }

                .statement-name {
                    font-size: 22px !important;
                }

                .single-cat .cat-icon img,
                .statement-photo-square {
                    max-width: 180px;
                }
            }
        </style>

    </main>

@endsection
