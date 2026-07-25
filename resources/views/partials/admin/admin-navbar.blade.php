<!-- Navbar -->
<div class="py-2 px-6 flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30 bg-sky-700">

    <button type="button" class="text-lg font-semibold text-white font-semibold sidebar-toggle">
        <i class="ri-menu-line"></i>
    </button>

    <!-- LIPA Logo -->
    <div class="flex items-center gap-2 ml-4">
        <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}" alt="LIPA Logo"
            class="h-8 w-8 object-contain">
        <span class="hidden sm:inline text-white font-bold text-sm tracking-wide">LIPA</span>
    </div>

    <ul class="ml-auto flex items-center">

        <!-- Notifications / Messages Dropdown -->
        <li class="dropdown">
            <button type="button"
                class="dropdown-toggle text-gray-400 mr-4 w-8 h-8 rounded flex items-center justify-center  hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    class="hover:bg-gray-100 rounded-full" viewBox="0 0 24 24"
                    style="fill: rgb(226, 15, 15);transform: ;msFilter:;">
                    <path
                        d="M19 13.586V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v3.586l-1.707 1.707A.996.996 0 0 0 3 16v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2a.996.996 0 0 0-.293-.707L19 13.586zM19 17H5v-.586l1.707-1.707A.996.996 0 0 0 7 14v-4c0-2.757 2.243-5 5-5s5 2.243 5 5v4c0 .266.105.52.293.707L19 16.414V17zm-7 5a2.98 2.98 0 0 0 2.818-2H9.182A2.98 2.98 0 0 0 12 22z">
                    </path>
                </svg>
            </button>
            <div
                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden max-w-xs w-full bg-white rounded-md border border-gray-100">
                <div class="flex items-center px-4 pt-4 border-b border-b-gray-100 notification-tab">
                    <button type="button" data-tab="notification" data-tab-page="notifications"
                        class="text-gray-400 font-medium text-[13px] hover:text-gray-600 border-b-2 border-b-transparent mr-4 pb-1 active">Notifications</button>
                    <button type="button" data-tab="notification" data-tab-page="messages"
                        class="text-gray-400 font-medium text-[13px] hover:text-gray-600 border-b-2 border-b-transparent mr-4 pb-1">Messages</button>
                </div>
                <div class="my-2">
                    <ul class="max-h-64 overflow-y-auto" data-tab-for="notification" data-page="notifications">
                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" alt=""
                                    class="w-8 h-8 rounded block object-cover align-middle">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
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
        <button id="fullscreen-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="hover:bg-gray-100 rounded-full"
                viewBox="0 0 24 24" style="fill: rgb(197, 63, 63);transform: ;msFilter:;">
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

        <!-- Admin image & name section -->
        <li class="dropdown ml-3">
            <button type="button" class="dropdown-toggle flex items-center">
                <div class="flex-shrink-0 w-10 h-10 relative">
                    @auth

                        @if (auth()->user()->image)
                            <div class="p-1 bg-white rounded-full focus:outline-none focus:ring">
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
                            <div class="p-1 bg-white rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-gray-800">
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
                        <div class="p-1 bg-white rounded-full flex items-center justify-center bg-gray-200">
                            <span class="text-sm font-bold text-gray-700">
                                ?
                            </span>
                        </div>

                    @endauth

                </div>


                <div class="p-2 md:block text-left">
                    <h2 class="text-sm font-semibold text-white">{{ Auth::user()->name }}</h2>
                    <p class="text-xs text-white/70">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
            </button>

            <ul
                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                <li>
                    <a href="#"
                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-[#f84525] hover:bg-gray-50">Profile</a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-[#f84525] hover:bg-gray-50">Settings</a>
                </li>
                <li>
                    <form method="POST" action="">
                        <a role="menuitem"
                            class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-[#f84525] hover:bg-gray-50 cursor-pointer"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                            Log Out
                        </a>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</div>
<!-- End Navbar -->
