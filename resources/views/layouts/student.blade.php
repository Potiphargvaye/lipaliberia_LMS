<!DOCTYPE html>
<html lang="en">

@include('partials.student.head')

<body>

    <div class="admin-shell">

        @include('partials.student.sidebar')

        <div class="admin-main">

            @include('partials.student.navbar')

            <main class="dashboard-content">
                @yield('content')
            </main>

            @include('partials.student.footer')

        </div>

    </div>

    @include('partials.student.scripts')

</body>

</html>
