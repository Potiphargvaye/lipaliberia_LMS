<!-- Sidenav -->
<div
    class="fixed left-0 top-0 w-64 h-screen z-50 sidebar-menu transition-transform bg-gradient-to-b from-sky-800 via-sky-700 to-sky-800 flex flex-col shadow-2xl shadow-black/20">

    <!-- Logo -->
    <a href="#" class="flex items-center h-[76px] px-5 shrink-0 relative">
        <h2 class="font-bold text-2xl tracking-tight text-white">
            LIPA <span
                class="bg-[#f84525] text-white text-base font-semibold px-2 py-0.5 rounded-md ml-1 align-middle shadow-sm shadow-[#f84525]/30">Liberia</span>
        </h2>
        <!-- subtle divider with brand glow -->
        <span
            class="absolute bottom-0 left-5 right-5 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></span>
    </a>

    <!-- SCROLLABLE MENU AREA -->
    <div class="flex-1 overflow-y-auto lipa-scroll px-3 pt-5 pb-6">

        <ul class="space-y-0.5">

            <li class="lipa-section">ADMIN</li>

            @can('view dashboard')
                <li class="mb-0.5 group">
                    <a href="{{ route('admin.dashboard') }}"
                        class="lipa-link {{ request()->routeIs('admin.dashboard') ? 'lipa-active' : '' }}">
                        <i class="ri-home-2-line lipa-icon"></i>
                        <span class="text-sm">Dashboard</span>
                    </a>
                </li>
            @endcan

            @can('manage users')
                @php
                    $usersSectionActive =
                        request()->routeIs('admin.access-control.users.*') || request()->routeIs('admin.users.*');
                @endphp
                <li class="mb-0.5 group {{ $usersSectionActive ? 'active selected' : '' }}">
                    <!-- Main Users Link -->
                    <a href="{{ route('admin.access-control.users.index') }}"
                        class="lipa-link sidebar-dropdown-toggle {{ $usersSectionActive ? 'lipa-active' : '' }}">
                        <i class='bx bx-user lipa-icon'></i>
                        <span class="text-sm">Users</span>
                        <i
                            class="ri-arrow-right-s-line ml-auto text-base transition-transform duration-200 group-[.selected]:rotate-90"></i>
                    </a>

                    <!-- Sub-links Dropdown -->
                    <ul class="mt-1 ml-[27px] pl-3 border-l border-white/15 hidden group-[.selected]:block space-y-1">

                        <li>
                            <a href="{{ route('admin.users.index') }}"
                                class="lipa-sublink {{ request()->routeIs('admin.users.index') ? 'lipa-active' : '' }}">
                                <span class="lipa-dot"></span>
                                All
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.users.permissions.edit', auth()->id()) }}"
                                class="lipa-sublink {{ request()->routeIs('admin.users.permissions.edit') ? 'lipa-active' : '' }}">
                                <span class="lipa-dot"></span>
                                User Permission
                            </a>
                        </li>

                    </ul>
                </li>
            @endcan

            @can('view students')
                <li class="mb-0.5 group">
                    <a href="{{ route('admin.students.index') }}"
                        class="lipa-link {{ request()->routeIs('admin.students.*') ? 'lipa-active' : '' }}">
                        <i class="ri-graduation-cap-line lipa-icon"></i>
                        <span class="text-sm">Students</span>
                    </a>
                </li>
            @endcan

            @can('manage grade assignments')
                <li class="mb-0.5 group">
                    <a href="{{ route('admin.grade-assignments') }}"
                        class="lipa-link {{ request()->routeIs('admin.grade-assignments') ? 'lipa-active' : '' }}">
                        <i class="ri-file-list-3-line lipa-icon"></i>
                        <span class="text-sm">Grade-Assignment</span>
                    </a>
                </li>
            @endcan

            <li class="mb-0.5 group">
                <a href="{{ route('admin.announcements.index') }}"
                    class="lipa-link {{ request()->routeIs('admin.announcements.*') ? 'lipa-active' : '' }}">
                    <i class="ri-megaphone-line lipa-icon"></i>
                    <span class="text-sm">Announcement</span>
                </a>
            </li>


            {{-- ===========================================================
| STUDENT MANAGEMENT
=========================================================== --}}
            <li class="lipa-section">STUDENT MANAGEMENT</li>

            @php
                $studentManagementActive =
                    request()->routeIs('admin.students.*') ||
                    request()->routeIs('admin.admissions.*') ||
                    request()->routeIs('admin.enrollments.*');
            @endphp

            <li class="mb-0.5 group {{ $studentManagementActive ? 'active selected' : '' }}">

                <!-- Main Menu -->
                <a href="#"
                    class="lipa-link sidebar-dropdown-toggle {{ $studentManagementActive ? 'lipa-active' : '' }}">

                    <i class="ri-graduation-cap-line lipa-icon"></i>

                    <span class="text-sm">Student Management</span>

                    <i
                        class="ri-arrow-right-s-line ml-auto text-base transition-transform duration-200 group-[.selected]:rotate-90"></i>

                </a>

                <!-- Dropdown -->
                <ul class="mt-1 ml-[27px] pl-3 border-l border-white/15 hidden group-[.selected]:block space-y-1">

                    {{-- Students --}}
                    @can('view students')
                        <li>
                            <a href="{{ route('admin.students.index') }}"
                                class="lipa-sublink {{ request()->routeIs('admin.students.*') ? 'lipa-active' : '' }}">
                                <span class="lipa-dot"></span>
                                Students
                            </a>
                        </li>
                    @endcan

                    {{-- Admissions --}}
                    @can('review applications')
                        <li>
                            <a href="{{ route('admin.admissions.index') }}"
                                class="lipa-sublink {{ request()->routeIs('admin.admissions.*') ? 'lipa-active' : '' }}">
                                <span class="lipa-dot"></span>
                                Admissions
                            </a>
                        </li>
                    @endcan

                    {{-- Enrollments --}}
                    @can('manage enrollments')
                        <li>
                            <a href="{{ route('admin.enrollments.index') }}"
                                class="lipa-sublink {{ request()->routeIs('admin.enrollments.*') ? 'lipa-active' : '' }}">
                                <span class="lipa-dot"></span>
                                Enrollments
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>


            <li class="lipa-section">ACCESS CONTROL</li>

            @can('view users')
                <li class="mb-0.5 group">
                    <a href="{{ route('admin.access-control.users.index') }}"
                        class="lipa-link {{ request()->routeIs('admin.access-control.users.*') ? 'lipa-active' : '' }}">
                        <i class="ri-user-settings-line lipa-icon"></i>
                        <span class="text-sm">Users</span>
                    </a>
                </li>
            @endcan

            @php
                $accessControlActive =
                    request()->routeIs('admin.access-control.roles.*') ||
                    request()->routeIs('admin.access-control.permissions.*') ||
                    request()->routeIs('admin.access-control.role-permissions.*');
            @endphp
            <li class="mb-0.5 group {{ $accessControlActive ? 'active selected' : '' }}">
                <!-- Main Access Control Link -->
                <a href="#"
                    class="lipa-link sidebar-dropdown-toggle {{ $accessControlActive ? 'lipa-active' : '' }}">

                    <i class="ri-shield-keyhole-line lipa-icon"></i>

                    <span class="text-sm">Access Control</span>

                    <i
                        class="ri-arrow-right-s-line ml-auto text-base transition-transform duration-200 group-[.selected]:rotate-90"></i>

                </a>

                <!-- Sub-links Dropdown -->
                <ul class="mt-1 ml-[27px] pl-3 border-l border-white/15 hidden group-[.selected]:block space-y-1">

                    <!-- Roles -->
                    @can('manage roles')
                        <li>
                            <a href="{{ route('admin.access-control.roles.index') }}"
                                class="lipa-sublink {{ request()->routeIs('admin.access-control.roles.*') ? 'lipa-active' : '' }}">
                                <span class="lipa-dot"></span>
                                Roles
                            </a>
                        </li>
                    @endcan

                    <!-- Permissions -->
                    @can('manage permissions')
                        <li>
                            <a href="{{ route('admin.access-control.permissions.index') }}"
                                class="lipa-sublink {{ request()->routeIs('admin.access-control.permissions.*') ? 'lipa-active' : '' }}">
                                <span class="lipa-dot"></span>
                                Permissions
                            </a>
                        </li>
                    @endcan

                    <!-- Role Permissions -->
                    @can('manage permissions')
                        <li>
                            <a href="{{ route('admin.access-control.role-permissions.index') }}"
                                class="lipa-sublink {{ request()->routeIs('admin.access-control.role-permissions.*') ? 'lipa-active' : '' }}">
                                <span class="lipa-dot"></span>
                                Role Permissions
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>

            <li class="lipa-section">BLOG</li>

            <li class="mb-0.5 group">
                <a href="" class="lipa-link">
                    <i class='bx bxl-blogger lipa-icon'></i>
                    <span class="text-sm">Post</span>
                </a>
            </li>

            <li class="mb-0.5 group">
                <a href="" class="lipa-link">
                    <i class='bx bx-archive lipa-icon'></i>
                    <span class="text-sm">Archive</span>
                </a>
            </li>


            <li class="lipa-section">PERSONAL</li>

            <li class="mb-0.5 group">
                <a href="" class="lipa-link">
                    <i class='bx bx-bell lipa-icon'></i>
                    <span class="text-sm">Notifications</span>
                </a>
            </li>

            <div x-data="{ showLogoutModal: false }">

                <!-- Logout List Item -->
                <li class="mb-0.5 group mt-2 pt-2 border-t border-white/10">
                    <button type="button" @click="showLogoutModal = true"
                        class="flex w-full items-center gap-3 px-3 py-2.5 rounded-lg font-semibold text-sm text-[#ff8a6b] transition-all duration-200 hover:bg-[#f84525]/15 hover:text-[#ffb3a0]">
                        <i class="ri-shut-down-line lipa-icon text-[#ff8a6b]"></i>
                        <span>Logout</span>
                    </button>
                </li>

                <!-- Logout Confirm Modal -->
                <div x-show="showLogoutModal" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center
               bg-black/60 backdrop-blur-sm px-2">
                    <div x-show="showLogoutModal" x-transition
                        class="bg-white w-full max-w-xs rounded-xl shadow-2xl overflow-hidden">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-4 py-3 bg-red-600 text-white">
                            <h3 class="text-sm font-semibold">Confirm Logout</h3>
                            <button @click="showLogoutModal = false"
                                class="p-1 rounded-full hover:bg-red-500/80 transition">
                                <i class="ri-close-line text-sm"></i>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="p-4 space-y-2 text-xs">
                            <p class="text-gray-700">
                                Are you sure you want to logout from the system?
                            </p>

                            <p class="text-red-600 flex items-center gap-1.5 text-[11px]">
                                <i class="ri-alert-line"></i>
                                You will need to login again to access the system.
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="px-4 py-3 bg-gray-50 border-t flex justify-end gap-2">
                            <button @click="showLogoutModal = false"
                                class="px-3 py-1.5 text-xs font-medium rounded-md border border-gray-200 hover:bg-gray-100 transition-colors">
                                Cancel
                            </button>

                            <form method="POST" action="{{ route('logout') }}" x-data="{ submitting: false }"
                                @submit="submitting = true">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1.5 text-xs font-semibold bg-red-600 text-white rounded-md
                   hover:bg-red-700 transition-colors flex items-center gap-2"
                                    :disabled="submitting">
                                    <!-- Spinner -->
                                    <svg x-show="submitting"
                                        class="animate-spin h-3 w-3 border-2 border-white border-t-transparent rounded-full"
                                        viewBox="0 0 24 24"></svg>

                                    <!-- Button text -->
                                    <span x-show="!submitting">Logout</span>
                                    <span x-show="submitting">Logging out…</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </ul>

    </div>
</div>

<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>

<!-- Sidebar-specific styles: section labels, link/hover/active states, custom scrollbar.
     Kept minimal and scoped to lipa-* classes / .sidebar-menu, no logic touched. -->
<style>
    .sidebar-menu .lipa-section {
        list-style: none;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.12em;
        color: rgba(224, 242, 254, 0.55);
        padding: 0 12px;
        margin: 22px 0 8px;
    }

    .sidebar-menu .lipa-section:first-child {
        margin-top: 4px;
    }

    .sidebar-menu .lipa-link {
        display: flex;
        align-items: center;
        gap: 0.1rem;
        padding: 0.6rem 0.75rem;
        border-radius: 0.6rem;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.92);
        border-left: 3px solid transparent;
        transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .sidebar-menu .lipa-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.06);
    }

    .sidebar-menu .lipa-link:hover .lipa-icon {
        color: #f84525;
        transform: translateX(2px);
    }

    /* Active (current page) link — locked to the hover treatment */
    .sidebar-menu .lipa-link.lipa-active {
        background-color: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        border-left-color: #f84525;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    .sidebar-menu .lipa-link.lipa-active .lipa-icon {
        color: #f84525;
    }

    .sidebar-menu .lipa-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.35rem;
        margin-right: 0.65rem;
        font-size: 1.05rem;
        flex-shrink: 0;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .sidebar-menu .lipa-sublink {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        font-size: 0.8125rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.75);
        padding: 0.4rem 0.6rem;
        border-radius: 0.5rem;
        transition: background-color 0.2s ease, color 0.2s ease, padding-left 0.2s ease;
    }

    .sidebar-menu .lipa-sublink:hover {
        background-color: rgba(248, 69, 37, 0.12);
        color: #ffffff;
        padding-left: 0.85rem;
    }

    .sidebar-menu .lipa-sublink:hover .lipa-dot {
        background-color: #f84525;
        transform: scale(1.3);
    }

    /* Active (current page) sub-link — locked to the hover treatment */
    .sidebar-menu .lipa-sublink.lipa-active {
        background-color: rgba(248, 69, 37, 0.18);
        color: #ffffff;
        padding-left: 0.85rem;
    }

    .sidebar-menu .lipa-sublink.lipa-active .lipa-dot {
        background-color: #f84525;
        transform: scale(1.3);
    }

    .sidebar-menu .lipa-dot {
        width: 5px;
        height: 5px;
        border-radius: 9999px;
        background-color: rgba(255, 255, 255, 0.4);
        flex-shrink: 0;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    /* Thin, brand-colored scrollbar */
    .lipa-scroll {
        scrollbar-width: thin;
        scrollbar-color: rgba(248, 69, 37, 0.55) transparent;
    }

    .lipa-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .lipa-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .lipa-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(248, 69, 37, 0.45);
        border-radius: 9999px;
    }

    .lipa-scroll::-webkit-scrollbar-thumb:hover {
        background-color: rgba(248, 69, 37, 0.75);
    }
</style>
<!-- End Sidenav -->
