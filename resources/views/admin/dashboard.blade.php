@extends('layouts.admin')

@section('content')
    <!-- Welcome Card -->
    <div class="glass-card mb-6">
        <div class="card-header">
            <div>
                <h2 class="card-title text-sky-300">
                    Welcome to the LIPA Administration Portal
                </h2>

                <p class="card-subtitle">
                    Manage admissions, students, courses, enrollments, fees, staff,
                    and institutional records from one centralized platform.
                </p>
            </div>
        </div>

        <div class="mt-5">
            <p class="text-gray-300 leading-7">
                This dashboard is currently being enhanced. Additional statistics,
                reports, charts, financial summaries, student analytics, and academic
                insights will appear here as more modules become available.
            </p>
        </div>
    </div>


    <!-- Coming Soon Modules -->
    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        <div class="glass-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title text-sky-300">
                        Admissions
                    </h2>
                    <p class="card-subtitle">
                        Coming Soon
                    </p>
                </div>
            </div>

            <p class="text-gray-300">
                View admission statistics, pending applications,
                approved candidates and enrollment trends.
            </p>
        </div>


        <div class="glass-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title text-sky-300">
                        Students
                    </h2>
                    <p class="card-subtitle">
                        Coming Soon
                    </p>
                </div>
            </div>

            <p class="text-gray-300">
                Student population, active learners,
                graduation tracking and academic performance
                will be displayed here.
            </p>
        </div>


        <div class="glass-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title text-sky-300">
                        Courses
                    </h2>
                    <p class="card-subtitle">
                        Coming Soon
                    </p>
                </div>
            </div>

            <p class="text-gray-300">
                Monitor course availability,
                enrollment capacity and program performance.
            </p>
        </div>


        <div class="glass-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title text-sky-300">
                        Finance
                    </h2>
                    <p class="card-subtitle">
                        Coming Soon
                    </p>
                </div>
            </div>

            <p class="text-gray-300">
                Fee collections, outstanding balances,
                invoices and financial summaries
                will appear here.
            </p>
        </div>


        <div class="glass-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title text-sky-300">
                        Reports
                    </h2>
                    <p class="card-subtitle">
                        Coming Soon
                    </p>
                </div>
            </div>

            <p class="text-gray-300">
                Generate academic reports,
                administrative reports,
                enrollment reports and printable documents.
            </p>
        </div>


        <div class="glass-card">
            <div class="card-header">
                <div>
                    <h2 class="card-title text-sky-300">
                        System Status
                    </h2>
                    <p class="card-subtitle">
                        Development
                    </p>
                </div>
            </div>

            <p class="text-gray-300">
                The LIPA Education Management System is
                currently under active development.
                New features and dashboard analytics will
                become available progressively.
            </p>
        </div>

    </section>
@endsection
