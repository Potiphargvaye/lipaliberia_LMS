<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In · LIPA Learning Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        lipa: {
                            primary: '#0F4C81',
                            sky: '#0EA5E9',
                            red: '#B91C1C',
                            dark: '#001a4d',
                        }
                    },
                    fontFamily: {
                        sans: ['Segoe UI', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            overflow-x: hidden;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(60px);
            opacity: 0.55;
            pointer-events: none;
        }

        .btn-verify {
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.12), 0 8px 20px -6px rgba(185, 28, 28, 0.55);
        }

        .btn-verify:hover {
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.25), 0 10px 26px -6px rgba(185, 28, 28, 0.7);
        }

        .btn-signin {
            background: linear-gradient(90deg, #278de7 0%, #B91C1C 100%);
            transition: filter 0.2s ease, transform 0.15s ease;
        }

        .btn-signin:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        .spinner {
            border-top-color: transparent;
        }

        .toggle-pill {
            transition: all 0.25s ease;
        }

        @media (max-width: 1023px) {
            .left-panel {
                border-bottom-left-radius: 0 !important;
                border-top-right-radius: 1.5rem !important;
            }
        }
    </style>
</head>

<body class="min-h-screen w-full font-sans"
    style="background: linear-gradient(135deg, #2ca7e0 0%, #0F4C81 55%, #1584b8 100%);">

    <!-- Ambient background glow shapes -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="blob bg-sky-400" style="width:420px;height:420px;top:-120px;left:-100px;"></div>
        <div class="blob bg-lipa-red" style="width:360px;height:360px;bottom:-100px;right:-80px;"></div>
        <div class="blob bg-lipa-sky" style="width:280px;height:280px;bottom:20%;left:8%;opacity:0.25;"></div>
    </div>

    <div class="relative min-h-screen w-full flex items-center justify-center px-4 py-8 lg:py-0">

        <div
            class="relative w-full max-w-5xl mx-auto rounded-3xl overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-2 bg-white/5">

            <!-- ============ LEFT PANEL — BRANDING ============ -->
            <div class="left-panel relative flex flex-col px-8 py-10 lg:py-12 lg:px-10"
                style="background: linear-gradient(160deg, #001a4d 0%, #0F4C81 60%, #B91C1C 130%);">

                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 text-white/80 hover:text-white text-sm font-medium w-fit mb-8 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 111.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to Home
                </a>

                <div class="flex flex-col items-center text-center mb-6">
                    <div
                        class="h-20 w-20 rounded-full bg-white/10 border border-white/20 flex items-center justify-center mb-5 overflow-hidden">
                        <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/lipa-logo.png') }}" alt="LIPA Logo"
                            class="h-16 w-16 object-contain">
                    </div>
                    <h1 class="text-white text-2xl lg:text-[26px] font-bold tracking-tight">Welcome to LIPA LMS</h1>
                    <p class="text-white/70 text-sm mt-3 max-w-xs leading-relaxed">
                        Access your learning portal to manage your courses, view schedules, and connect across the
                        public service network.
                    </p>
                </div>

                <div class="flex flex-col gap-3 mt-2">
                    <div class="glass-card rounded-xl px-4 py-3 flex items-center gap-3 transition">
                        <div
                            class="h-9 w-9 rounded-lg bg-lipa-red/30 border border-white/20 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-white" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.681-.056-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-white text-sm font-semibold leading-tight">Secure Access</p>
                            <p class="text-white/60 text-xs mt-0.5">Enterprise-grade security for your data</p>
                        </div>
                    </div>

                    <div class="glass-card rounded-xl px-4 py-3 flex items-center gap-3 transition">
                        <div
                            class="h-9 w-9 rounded-lg bg-lipa-sky/30 border border-white/20 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-white" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-white text-sm font-semibold leading-tight">Digital Portal</p>
                            <p class="text-white/60 text-xs mt-0.5">Access courses, grades, and learning materials</p>
                        </div>
                    </div>

                    <div class="glass-card rounded-xl px-4 py-3 flex items-center gap-3 transition">
                        <div
                            class="h-9 w-9 rounded-lg bg-white/15 border border-white/20 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-white" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-white text-sm font-semibold leading-tight">Public Administration</p>
                            <p class="text-white/60 text-xs mt-0.5">Empowering public service through digital learning
                            </p>
                        </div>
                    </div>
                </div>

                <button type="button"
                    class="btn-verify mt-6 w-full rounded-xl bg-white/10 hover:bg-white/15 border border-white/25 text-white text-sm font-semibold py-3 flex items-center justify-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 4a1 1 0 011-1h2a1 1 0 010 2H5v2a1 1 0 01-2 0V4zm10-1a1 1 0 000 2h1v2a1 1 0 002 0V4a1 1 0 00-1-1h-2zM3 14a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 100-2H5v-2a1 1 0 00-1-1zm14 1a1 1 0 10-2 0v2h-2a1 1 0 100 2h2a1 1 0 001-1v-3zM8 8a1 1 0 000 2h4a1 1 0 100-2H8z"
                            clip-rule="evenodd" />
                    </svg>
                    Verify Student / Staff ID
                </button>

                <p class="mt-auto pt-8 text-white/40 text-[11px] text-center hidden lg:block">
                    &copy; {{ date('Y') }} Liberia Institute of Public Administration
                </p>
            </div>

            <!-- ============ RIGHT PANEL — AUTH FORM ============ -->
            <div class="relative bg-white px-8 py-10 lg:py-12 lg:px-10 flex flex-col justify-center">

                <div class="w-full max-w-sm mx-auto">
                    <h2 class="text-2xl font-bold text-lipa-dark">Sign In</h2>
                    <p class="text-slate-500 text-sm mt-1 mb-6">Enter your credentials to continue</p>

                    {{-- Laravel validation errors --}}
                    @if ($errors->any())
                        <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3">
                            <p class="text-sm font-semibold text-lipa-red mb-1">There was a problem signing you in</p>
                            <ul class="text-xs text-red-700 list-disc list-inside space-y-0.5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('status'))
                        <div
                            class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-5">
                        @csrf

                        <!-- Account Type Toggle -->
                        <div>
                            <label
                                class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Account
                                Type</label>
                            <div class="grid grid-cols-2 gap-2 bg-slate-100 rounded-xl p-1">
                                <button type="button" id="tabStudent"
                                    class="toggle-pill account-tab active-tab rounded-lg py-2 text-sm font-semibold"
                                    data-type="student">
                                    Student
                                </button>
                                <button type="button" id="tabStaff"
                                    class="toggle-pill account-tab rounded-lg py-2 text-sm font-semibold text-slate-500"
                                    data-type="staff">
                                    Staff / Admin
                                </button>
                            </div>
                            <input type="hidden" name="account_type" id="accountTypeField" value="student">
                        </div>

                        <!-- Dynamic credential field -->
                        <div>
                            <label for="credential" id="credentialLabel"
                                class="block text-sm font-medium text-slate-700 mb-1.5">
                                Registration ID
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="h-8 w-8 rounded-md bg-lipa-primary flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                                <input type="text" name="login" id="credential" value="{{ old('login') }}"
                                    placeholder="LIPA/STU/2026/0001" required autofocus
                                    class="w-full rounded-lg border border-slate-300 pl-14 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-lipa-sky focus:border-lipa-sky transition">
                            </div>
                            @error('login')
                                <p class="text-xs text-lipa-red mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password"
                                class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="h-8 w-8 rounded-md bg-lipa-primary flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    required
                                    class="w-full rounded-lg border border-slate-300 pl-14 pr-11 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-lipa-sky focus:border-lipa-sky transition">
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-xs text-lipa-red mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember + Forgot -->
                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center gap-2 text-slate-600 select-none cursor-pointer">
                                <input type="checkbox" name="remember"
                                    class="rounded border-slate-300 text-lipa-primary focus:ring-lipa-sky">
                                Remember me
                            </label>
                            <a href="{{ route('password.request') }}"
                                class="text-lipa-red font-medium hover:underline">Forgot password?</a>
                        </div>

                        <!-- Submit -->
                        <button type="submit" id="submitBtn"
                            class="btn-signin w-full rounded-lg text-white font-semibold py-3 text-sm flex items-center justify-center gap-2 shadow-lg shadow-lipa-primary/20">
                            <span id="btnText" class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V7.414a1 1 0 00-.293-.707L10.293 2.293A1 1 0 009.586 2H3zm7 6a1 1 0 011 1v.01a1 1 0 11-2 0V10a1 1 0 011-1zm-4 4a1 1 0 100 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Sign In to LIPA LMS
                            </span>
                            <svg id="spinner" class="animate-spin h-4 w-4 text-white hidden spinner"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4" fill="none"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </button>

                        <div class="relative py-1">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-slate-200"></div>
                            </div>
                            <div class="relative flex justify-center"><span
                                    class="bg-white px-3 text-xs text-slate-400">or</span></div>
                        </div>

                        <p class="text-center text-sm text-slate-500">
                            Not have an Account? <a href=""
                                class="text-lipa-primary font-semibold hover:underline">Apply for Enrollment</a>
                        </p>
                        <p class="text-center">
                            <a href=""
                                class="text-xs text-lipa-sky font-medium hover:underline inline-flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd" />
                                </svg>
                                Check Application Status
                            </a>
                        </p>
                    </form>

                    <p class="text-center text-[11px] text-slate-400 mt-8">
                        Liberia Institute of Public Administration
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ---- Account type toggle ----
        const tabStudent = document.getElementById('tabStudent');
        const tabStaff = document.getElementById('tabStaff');
        const accountTypeField = document.getElementById('accountTypeField');
        const credentialLabel = document.getElementById('credentialLabel');
        const credentialInput = document.getElementById('credential');

        function setActiveTab(type) {
            const isStudent = type === 'student';

            tabStudent.classList.toggle('bg-white', isStudent);
            tabStudent.classList.toggle('shadow', isStudent);
            tabStudent.classList.toggle('text-lipa-primary', isStudent);
            tabStudent.classList.toggle('text-slate-500', !isStudent);

            tabStaff.classList.toggle('bg-white', !isStudent);
            tabStaff.classList.toggle('shadow', !isStudent);
            tabStaff.classList.toggle('text-lipa-primary', !isStudent);
            tabStaff.classList.toggle('text-slate-500', isStudent);

            accountTypeField.value = type;

            if (isStudent) {
                credentialLabel.textContent = 'Registration ID';
                credentialInput.type = 'text';
                credentialInput.placeholder = 'LIPA/STU/2026/0001';
                credentialInput.name = 'login';
            } else {
                credentialLabel.textContent = 'Email Address';
                credentialInput.type = 'email';
                credentialInput.placeholder = 'admin@lipa.gov.lr';
                credentialInput.name = 'login';
            }
        }

        tabStudent.addEventListener('click', () => setActiveTab('student'));
        tabStaff.addEventListener('click', () => setActiveTab('staff'));
        setActiveTab('student'); // default state on load

        // ---- Password visibility toggle ----
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        const eyeOpenPath =
            `<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />`;
        const eyeClosedPath =
            `<path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.781-1.781zm4.261 4.26l1.514 1.515a2 2 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" /><path d="M2.458 10c.907 1.984 2.633 3.657 4.717 4.717l-1.98-1.981A5.019 5.019 0 013.958 10c.363-.798.875-1.516 1.502-2.113l1.427 1.427c-.114.278-.173.581-.173.898a5 5 0 006.928 4.622l1.44 1.44A9.958 9.958 0 0110 17c-4.478 0-8.268-2.943-9.542-7 .34-1.084.87-2.083 1.556-2.965l.444.444z" />`;

        togglePassword.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            eyeIcon.innerHTML = isHidden ? eyeClosedPath : eyeOpenPath;
        });

        // ---- Loading state on submit ----
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const spinner = document.getElementById('spinner');

        loginForm.addEventListener('submit', () => {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
            btnText.innerHTML = 'Signing you in...';
            spinner.classList.remove('hidden');
        });
    </script>
</body>

</html>
