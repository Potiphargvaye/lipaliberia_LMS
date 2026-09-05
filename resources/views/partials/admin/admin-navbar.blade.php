<!-- Navbar -->
<div
    class="py-2.5 px-6 flex items-center sticky top-0 left-0 z-30 bg-gradient-to-r from-sky-800 via-sky-700 to-sky-800 border-b border-white/10 shadow-lg shadow-black/10">

    <button type="button" class="nav-icon-btn sidebar-toggle">
        <i class="ri-menu-line text-xl"></i>
    </button>

    <span class="h-6 w-px bg-white/15 mx-3 hidden sm:block"></span>

    <!-- LIPA Logo -->
    <div class="flex items-center gap-2.5">
        <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}" alt="LIPA Logo"
            class="h-8 w-8 object-contain rounded-md bg-white/10 p-0.5">
        <span class="hidden sm:inline text-white font-bold text-sm tracking-wider">LIBERIA INSTITUDE OF PUBLIC
            ADMINISTRATION</span>
    </div>

    <ul class="ml-auto flex items-center gap-1.5">

        <!-- Notifications / Messages Dropdown -->
        <li class="dropdown">
            <button type="button" class="dropdown-toggle nav-icon-btn group relative">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                    class="fill-current text-white/85 group-hover:text-white transition-colors">
                    <path
                        d="M19 13.586V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v3.586l-1.707 1.707A.996.996 0 0 0 3 16v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2a.996.996 0 0 0-.293-.707L19 13.586zM19 17H5v-.586l1.707-1.707A.996.996 0 0 0 7 14v-4c0-2.757 2.243-5 5-5s5 2.243 5 5v4c0 .266.105.52.293.707L19 16.414V17zm-7 5a2.98 2.98 0 0 0 2.818-2H9.182A2.98 2.98 0 0 0 12 22z">
                    </path>
                </svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#f84525] ring-2 ring-sky-700"></span>
            </button>
            <div
                class="dropdown-menu z-30 hidden w-80 max-w-xs bg-white rounded-xl border border-gray-100 shadow-xl shadow-black/10 overflow-hidden">
                <div class="flex items-center px-4 pt-3 border-b border-b-gray-100 notification-tab">
                    <button type="button" data-tab="notification" data-tab-page="notifications"
                        class="nav-tab active">Notifications</button>
                    <button type="button" data-tab="notification" data-tab-page="messages"
                        class="nav-tab">Messages</button>
                </div>
                <div class="my-1.5">
                    <ul class="max-h-64 overflow-y-auto navbar-scroll" data-tab-for="notification"
                        data-page="notifications">
                        <li>
                            <a href="#"
                                class="py-2.5 px-4 flex items-center gap-3 hover:bg-sky-50/70 transition-colors group mx-1.5 rounded-lg">
                                <img src="https://placehold.co/32x32" alt=""
                                    class="w-8 h-8 rounded-full block object-cover align-middle ring-1 ring-gray-100 shrink-0">
                                <div class="min-w-0">
                                    <div
                                        class="text-[13px] text-gray-700 font-semibold truncate group-hover:text-sky-700 transition-colors">
                                        New order</div>
                                    <div class="text-[11px] text-gray-400">from a user</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>

        <!-- Fullscreen button -->
        <button id="fullscreen-button" class="nav-icon-btn group">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                class="fill-current text-white/85 group-hover:text-white transition-colors">
                <path d="M5 5h5V3H3v7h2zm5 14H5v-5H3v7h7zm11-5h-2v5h-5v2h7zm-2-4h2V3h-7v2h5z"></path>
            </svg>
        </button>
        <script>
            const fullscreenButton = document.getElementById('fullscreen-button');
            fullscreenButton.addEventListener('click', toggleFullscreen);

            function toggleFullscreen() {
                if (document.fullscreenElement) {
                    document.exitFullscreen();
                } else {
                    document.documentElement.requestFullscreen();
                }
            }
        </script>

        <span class="h-6 w-px bg-white/15 mx-1.5 hidden sm:block"></span>

        <!-- Admin image & name section -->
        <li class="dropdown">
            <button type="button"
                class="dropdown-toggle flex items-center gap-0.5 rounded-lg px-2 py-1.5 hover:bg-white/10 transition-colors">
                <div class="shrink-0 w-10 h-10 relative">
                    @auth

                        @if (auth()->user()->image)
                            <div class="p-0.5 bg-white/15 ring-1 ring-white/20 rounded-full focus:outline-none focus:ring">
                                <img class="w-8 h-8 rounded-full object-cover"
                                    src="{{ asset('storage/' . auth()->user()->image) }}"
                                    alt="{{ auth()->user()->name }}" />
                                <div
                                    class="top-0 left-7 absolute w-3 h-3 bg-lime-400 border-2 border-white rounded-full animate-ping">
                                </div>
                                <div class="top-0 left-7 absolute w-3 h-3 bg-lime-500 border-2 border-white rounded-full">
                                </div>
                            </div>
                        @else
                            <div
                                class="p-0.5 bg-white/15 ring-1 ring-white/20 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <div
                                    class="top-0 left-7 absolute w-3 h-3 bg-lime-400 border-2 border-white rounded-full animate-ping">
                                </div>
                                <div class="top-0 left-7 absolute w-3 h-3 bg-lime-500 border-2 border-white rounded-full">
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="p-0.5 bg-white/15 ring-1 ring-white/20 rounded-full flex items-center justify-center">
                            <span class="text-sm font-bold text-white/80">
                                ?
                            </span>
                        </div>

                    @endauth

                </div>


                <div class="pl-2 md:block text-left leading-tight">
                    <h2 class="text-sm font-semibold text-white">
                        {{ Auth::user()?->name ?? 'Guest' }}
                    </h2>
                    <p class="text-xs text-white/65">
                        {{ Auth::user()?->role ?? '' }}
                    </p>
                </div>
                <i class="ri-arrow-down-s-line text-white/60 ml-1 text-base"></i>
            </button>

            <ul
                class="dropdown-menu z-30 hidden py-1.5 rounded-xl bg-white border border-gray-100 shadow-xl shadow-black/10 w-full max-w-[170px]">
                <li>
                    <a href="#" class="nav-dropdown-link">
                        <i class="ri-user-line text-[15px]"></i>
                        Profile</a>
                </li>
                <li>
                    <a href="#" class="nav-dropdown-link">
                        <i class="ri-settings-3-line text-[15px]"></i>
                        Settings</a>
                </li>
                <li class="mt-1 pt-1 border-t border-gray-100">
                    <form method="POST" action="">
                        <a role="menuitem" class="nav-dropdown-link nav-dropdown-link--danger cursor-pointer"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                            <i class="ri-logout-box-r-line text-[15px]"></i>
                            Log Out
                        </a>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</div>

<!-- Navbar-specific styles: icon buttons, tabs, dropdown links, scrollbar.
     Scoped to nav-* classes only, no logic touched. -->
<style>
    .nav-icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        color: rgba(255, 255, 255, 0.85);
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .nav-icon-btn:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    .nav-tab {
        color: rgba(107, 114, 128, 1);
        font-weight: 600;
        font-size: 12.5px;
        border-bottom: 2px solid transparent;
        margin-right: 1rem;
        padding-bottom: 0.5rem;
        transition: color 0.2s ease, border-color 0.2s ease;
    }

    .nav-tab:hover {
        color: #0369a1;
    }

    .nav-tab.active {
        color: #f84525;
        border-bottom-color: #f84525;
    }

    .nav-dropdown-link {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 13px;
        font-weight: 500;
        color: rgba(75, 85, 99, 1);
        padding: 0.5rem 1rem;
        margin: 0 0.35rem;
        border-radius: 0.5rem;
        width: calc(100% - 0.7rem);
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .nav-dropdown-link:hover {
        color: #f84525;
        background-color: rgba(248, 69, 37, 0.08);
    }

    .nav-dropdown-link--danger {
        color: #dc2626;
    }

    .nav-dropdown-link--danger:hover {
        color: #ffffff;
        background-color: #dc2626;
    }

    .navbar-scroll {
        scrollbar-width: thin;
        scrollbar-color: rgba(248, 69, 37, 0.45) transparent;
    }

    .navbar-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .navbar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .navbar-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(248, 69, 37, 0.4);
        border-radius: 9999px;
    }
</style>
<!-- End Navbar -->
