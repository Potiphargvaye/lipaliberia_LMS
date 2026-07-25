@extends('layouts.admin')

@section('content')
    <div class="flex justify-center items-start min-h-[80vh]">
        <!-- Keep your original background and orbs -->
        <div class="background"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>

        <!-- Keep the original main-content with glass style -->
        <main class="main-content !ml-0 mt-12 w-full max-w-[1200px] px-4">
            <!-- Top Navbar -->
            <nav class="navbar mb-6">
                <h1 class="page-title colo" style="color: aliceblue">Dashboard Overview</h1>
                <div class="navbar-right flex items-center gap-4">
                    <div class="search-box flex items-center gap-2">
                        <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                        <input type="text" class="search-input" placeholder="Search anything...">
                    </div>
                    <button class="nav-btn relative">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <span class="notification-dot absolute top-0 right-0"></span>
                    </button>
                    <button class="nav-btn" id="theme-toggle" title="Toggle Light/Dark Mode">
                        <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="4" />
                            <path d="M12 2v2" />
                            <path d="M12 20v2" />
                            <path d="M4.93 4.93l1.41 1.41" />
                            <path d="M17.66 17.66l1.41 1.41" />
                            <path d="M2 12h2" />
                            <path d="M20 12h2" />
                            <path d="M6.34 17.66l-1.41 1.41" />
                            <path d="M19.07 4.93l-1.41 1.41" />
                        </svg>
                        <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            style="display: none;">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
                        </svg>
                    </button>
                </div>
            </nav>




            <!-- Donut Chart -->
            <div class="glass-card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title" style="color: aquamarine">Traffic Sources</h2>
                        <p class="card-subtitle">User acquisition breakdown</p>
                    </div>
                </div>
                <div class="donut-container">
                    <div class="donut-chart">
                        <svg width="140" height="140" viewBox="0 0 140 140">
                            <circle class="donut-bg" cx="70" cy="70" r="54" />
                            <circle class="donut-segment" cx="70" cy="70" r="54" stroke="var(--emerald-light)"
                                stroke-dasharray="169.6 339.3" stroke-dashoffset="0" />
                            <circle class="donut-segment" cx="70" cy="70" r="54" stroke="var(--gold)"
                                stroke-dasharray="101.8 339.3" stroke-dashoffset="-169.6" />
                            <circle class="donut-segment" cx="70" cy="70" r="54" stroke="var(--coral)"
                                stroke-dasharray="67.9 339.3" stroke-dashoffset="-271.4" />
                        </svg>
                        <div class="donut-center">
                            <div class="donut-value" style="color: aqua">24.5K</div>
                            <div class="donut-label">Visitors</div>
                        </div>
                    </div>
                    <div class="donut-legend">
                        <div class="legend-item"><span class="legend-color cyan"></span><span>Organic Search
                                (50%)</span></div>
                        <div class="legend-item"><span class="legend-color magenta"></span><span>Social Media
                                (30%)</span></div>
                        <div class="legend-item"><span class="legend-color purple"></span><span>Direct Traffic
                                (20%)</span></div>
                    </div>
                </div>
            </div>

            <!-- Progress Card -->
            <div class="glass-card progress-card">
                <div class="card-header">
                    <div>
                        <h2 class="card-title" style="color: aqua">Students Progress by class</h2>
                        <p class="card-subtitle" style="color: aqua">Coming-Soon!</p>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-header"><span class="progress-label">Grade 9th</span><span
                            class="progress-value">85%</span></div>
                    <div class="progress-bar">
                        <div class="progress-fill cyan" style="width: 85%;"></div>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-header"><span class="progress-label">Grade 10th</span><span
                            class="progress-value">62%</span></div>
                    <div class="progress-bar">
                        <div class="progress-fill magenta" style="width: 62%;"></div>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-header"><span class="progress-label">Grade 11th</span><span
                            class="progress-value">45%</span></div>
                    <div class="progress-bar">
                        <div class="progress-fill purple" style="width: 45%;"></div>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-header"><span class="progress-label">Grade 12th </span><span
                            class="progress-value">28%</span></div>
                    <div class="progress-bar">
                        <div class="progress-fill cyan" style="width: 28%;"></div>
                    </div>
                </div>
            </div>
            </section>
        </main>
    </div>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="12" x2="21" y2="12" />
            <line x1="3" y1="6" x2="21" y2="6" />
            <line x1="3" y1="18" x2="21" y2="18" />
        </svg>
    </button>
@endsection
