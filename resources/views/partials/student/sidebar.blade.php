<div class="sidebar-backdrop" data-sidebar-close></div>

<aside class="admin-sidebar" id="adminSidebar" aria-label="Student navigation">

    {{-- Sidebar Header --}}
    <div class="sidebar-header">

        <a class="brand-mark" href="{{ route('student.dashboard') }}" aria-label="LIPA LMS Dashboard">

            <span
                class="brand-icon rounded-circle overflow-hidden bg-white d-flex align-items-center justify-content-center"
                style="width: 46px; height: 46px; flex-shrink: 0;">

                <img src="{{ asset('logo/lipa-logo.png') }}" alt="LIPA Logo"
                    style="width: 100%; height: 100%; object-fit: cover;">

            </span>

            <span class="brand-copy">
                <span class="brand-title">LIPA Liberia</span>
                <span class="brand-subtitle">LIPA LMS</span>
            </span>

        </a>

    </div>


    {{-- Navigation --}}
    <nav class="sidebar-nav">

        {{-- Dashboard --}}
        <a class="nav-link active" href="{{ route('student.dashboard') }}" aria-current="page">

            <span class="nav-icon">
                <i class="bi bi-speedometer2" aria-hidden="true"></i>
            </span>

            <span class="nav-text">Dashboard</span>

        </a>


        {{-- My Courses --}}
        <a class="nav-link" href="#">
            <span class="nav-icon">
                <i class="bi bi-journal-bookmark" aria-hidden="true"></i>
            </span>

            <span class="nav-text">My Courses</span>
        </a>


        {{-- My Learning --}}
        <a class="nav-link" href="#">
            <span class="nav-icon">
                <i class="bi bi-mortarboard" aria-hidden="true"></i>
            </span>

            <span class="nav-text">My Learning</span>
        </a>


        {{-- Assignments --}}
        <a class="nav-link" href="#">
            <span class="nav-icon">
                <i class="bi bi-journal-check" aria-hidden="true"></i>
            </span>

            <span class="nav-text">Assignments</span>
        </a>


        {{-- Quizzes --}}
        <a class="nav-link" href="#">
            <span class="nav-icon">
                <i class="bi bi-ui-checks-grid" aria-hidden="true"></i>
            </span>

            <span class="nav-text">Quizzes & Assessments</span>
        </a>


        {{-- Fees --}}
        <a class="nav-link" href="{{ route('student.fees.index') }}">

            <span class="nav-icon">
                <i class="bi bi-wallet2" aria-hidden="true"></i>
            </span>

            <span class="nav-text">Fees & Payments</span>

        </a>


        {{-- Live Classes --}}
        <a class="nav-link" href="{{ route('student.live-classes.index') }}">
            <span class="nav-icon">
                <i class="bi bi-camera-video" aria-hidden="true"></i>
            </span>

            <span class="nav-text">Live Classes</span>

        </a>



        {{-- Community --}}
        <a class="nav-link" href="#">

            <span class="nav-icon">
                <i class="bi bi-chat-dots" aria-hidden="true"></i>
            </span>

            <span class="nav-text">Community</span>

        </a>


        {{-- Certificates --}}
        <a class="nav-link" href="#">

            <span class="nav-icon">
                <i class="bi bi-award" aria-hidden="true"></i>
            </span>

            <span class="nav-text">Certificates</span>

        </a>


        {{-- Notifications --}}
        <a class="nav-link" href="#">

            <span class="nav-icon">
                <i class="bi bi-bell" aria-hidden="true"></i>
            </span>

            <span class="nav-text">Notifications</span>

        </a>


        {{-- Profile --}}
        <a class="nav-link" href="#">

            <span class="nav-icon">
                <i class="bi bi-person-circle" aria-hidden="true"></i>
            </span>

            <span class="nav-text">Profile</span>

        </a>


        {{-- Settings --}}
        <a class="nav-link" href="#">

            <span class="nav-icon">
                <i class="bi bi-gear" aria-hidden="true"></i>
            </span>

            <span class="nav-text">Settings</span>

        </a>

    </nav>

    {{-- Logout --}}
    <div class="px-3 pb-3">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="nav-link w-100 border-0 d-flex align-items-center text-start"
                style="
                background: rgba(220, 38, 38, 0.10);
                color: #ef4444;
                border-radius: 10px;
                transition: all 0.25s ease;
            "
                onmouseover="this.style.background='rgba(220, 38, 38, 0.18)'; this.style.color='#f87171';"
                onmouseout="this.style.background='rgba(220, 38, 38, 0.10)'; this.style.color='#ef4444';">

                <span class="nav-icon">
                    <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                </span>

                <span class="nav-text">
                    Logout
                </span>

            </button>

        </form>

    </div>
    {{-- Sidebar Footer --}}
    <div class="sidebar-footer">

        <span class="status-dot"></span>

        <span class="sidebar-footer-text">
            LIPA LMS
        </span>

    </div>

</aside>
